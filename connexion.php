<?php

/**
 * Page de connexion
 *
 * @author MK
 */

require_once 'common.php';

// si connecté on redirige vers l'index
if($auth->est_connecte()) {
    header('Location: index.php');
}

if(isset($_POST['login']) && isset($_POST['pass'])) {
    $login = trim($_POST['login']);
    $pass = $_POST['pass'];
    if($auth->verifieIdentifiants($login, $pass)) {
        header('Location: index.php');
    } else {
        $template->affiche('message', array(
            'titre_page' => 'Mauvais identifiants',
            'message_titre' => 'Mauvais identifiants',
            'message_contenu' => 'Login et/ou mot de passe incorrect(s), veuillez <a href="connexion.php">réessayer</a>.'
        ));
    }
} else {
    $template->affiche('connexion', array(
        'titre_page' => 'Connexion'
    ));
}

?>