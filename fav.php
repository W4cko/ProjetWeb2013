<?php

/**
 * Ajout/suppression d'un favoris
 *
 * @author MK
 */

require_once 'common.php';

if(!isset($_GET['action']) ||
    !in_array($_GET['action'], array('add', 'del')) ||
    !isset($_GET['insee']) &&
    strlen($_GET['insee']) == 5)  {
    header('Location: index.php'); // on redirige si l'url contient des mauvais paramètres
} elseif($auth->est_connecte()) {
    $insee = trim($_GET['insee']);
    $CommuneManager = new CommuneManager();
    $FavorisManager = new FavorisManager($user->get('id'));
    $est_favoris = $FavorisManager->est_favorite($insee);

    if($_GET['action'] == 'add' && $CommuneManager->existe($insee) && !$est_favoris) {
        $FavorisManager->add($insee);
    } elseif($_GET['action'] == 'del' && $est_favoris) { // pas besoin de verifier qu'elle existe, car si elle est favorite c'est qu'elle existe
        $FavorisManager->del($insee);
    }
    // redirection vers la page précédente
    $past = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $past); 
} else {
    $template->affiche('message', array(
        'titre_page' => 'Erreur',
        'message_titre' => 'Veuillez-vous connecter',
        'message_contenu' => 'Vous devez vous <a href="connexion.php">connecter</a> pour ajouter des favoris, si vous n\'avez pas de compte, veuillez <a href="inscription.php">vous inscrire</a>.'
    ));
}


?>
