<?php

/**
 * Liste des favoris
 *
 * @author MK
 */

require_once 'common.php';

// si pas connecté on redirige vers l'index
if(!$auth->est_connecte()) {
    header('Location: index.php');
}

$FavorisManager = new FavorisManager($user->get('id'));
$CommuneManager = new CommuneManager();

$count = $FavorisManager->nb();

if($count == 0) {
    $template->affiche('message', array(
        'titre_page' => 'Aucun favoris',
        'message_titre' => 'Aucun favoris',
        'message_contenu' => 'Vous n\'avez aucun favoris.'
    ));
} else {
    $liste = $FavorisManager->get();
    $communes = $CommuneManager->communes($liste);
    $template->affiche('favoris', array(
        'titre_page' => 'Favoris ('.$count.')',
        'communes' => $communes,
        'count' => $count
    ));
}

?>