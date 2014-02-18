<?php

/**
 * Page d'inscription
 *
 * @author MK
 */

require_once 'common.php';

// si connecté on redirige vers l'index
if($auth->est_connecte()) {
    header('Location: index.php');
}

if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['passconf'])) {

    $login = trim($_POST['login']);
    $pass = $_POST['pass'];
    $passconf = $_POST['passconf'];

    $erreurs = array();

    // verification du format du pseudo
    if(mb_strlen($login) < 3 ||mb_strlen($login) > 50 || !preg_match('/[a-zA-Z0-9]+/', $login)) {
        $erreurs[] = 'Le login doit uniquement contenir des caractères alphanumériques et avoir une longueur comprise entre 3 et 50 caractères.';
    }

    // verification le mot de passe
    if(mb_strlen($pass) < 3) {
        $erreurs[] = 'Le mot de passe doit contenir au moins 3 caractères.';
    }

    if($pass != $passconf) {
        $erreurs[] = 'Le mot de passe de vérification doit être identique au mot de passe.';
    } else {
        $pass = md5($pass);
    }

    // on vérifie si le login est déjà pris
    $UserManager = new UserManager();
    if($UserManager->existe($login)) {
        $erreurs[] = 'Le login choisi est déjà pris.';
    }

    // si il y a des erreurs on les affiche
    $nb_erreurs = count($erreurs);
    if($nb_erreurs > 0) {
        $template->affiche('message', array(
            'titre_page' => ($nb_erreurs == 1) ? 'Erreur' : 'Erreurs',
            'message_titre' => ($nb_erreurs == 1) ? 'Erreur' : 'Erreurs',
            'message_contenu' => '<ul><li>'.implode('</li><li>', $erreurs).'</li></ul><p>Veuillez <a href="inscription.php">réessayer</a>.</p>'
        ));
        exit();
    }

    // sinon on ajoute l'utilisateur
    $UserManager->add($login, $pass);
    $template->affiche('message', array(
        'titre_page' => 'Inscription réussie',
        'message_titre' => 'Inscription réussie',
        'message_contenu' => 'Vous pouvez maintenant vous <a href="connexion.php">connecter</a> avec votre login et votre mot de passe.'
    ));

} else {
    $template->affiche('inscription', array(
        'titre_page' => 'Inscription'
    ));
}

?>