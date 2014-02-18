<?php

/**
 * Résultats de recherche
 *
 * @author MK
 */

require_once 'common.php';

$CommuneManager = new CommuneManager();

// Paramètres
$nom = (isset($_GET['nom'])) ? trim(NormalizerCustom::normalize($_GET['nom'])) : null;
$insee = (isset($_GET['insee'])) ? trim($_GET['insee']) : null;
$reg = (isset($_GET['reg'])) ? trim($_GET['reg']) : null;
$dep = (isset($_GET['dep'])) ? trim($_GET['dep']) : null;
$popmin = (isset($_GET['popmin']) && is_numeric($_GET['popmin']) && $_GET['popmin'] > 0) ? trim($_GET['popmin']) : null;
$popmax = (isset($_GET['popmax']) && is_numeric($_GET['popmax']) && $_GET['popmax'] > 0) ? trim($_GET['popmax']) : null;

$criteres = array(
    'nom'         =>  $nom,
    'insee'       =>  $insee,
    'region'      =>  $reg,
    'departement' =>  $dep,
    'popmin'      =>  $popmin,
    'popmax'      =>  $popmax
);

// Nombre de résultats de recherche
$count = $CommuneManager->count($criteres);

if($count == 0) {
    $template->affiche('message', array(
        'titre_page' => 'Aucun résultat',
        'message_titre' => 'Aucun résultat',
        'message_contenu' => 'Veuillez recommencer avec d\'autres termes'
    ));
} else {
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) && ceil($count/15) >= $_GET['page']) ? $_GET['page'] : 1;
    $resultats = $CommuneManager->search($criteres, $page);

    $template->affiche('recherche', array(
        'titre_page' => $count . ' résultats',
        'nombre' => $count,
        'resultats' => $resultats,
        'count' => $count,
        'page' => $page,
        'nb_pages' => ceil($count/15),
        'url_sans_page' => 'recherche.php?nom='.$nom.
                           '&amp;reg='.$reg.
                           '&amp;popmin='.$popmin.
                           '&amp;insee='.$insee.
                           '&amp;dep='.$dep.
                           '&amp;popmax='.$popmax,
        'pages_a_afficher' => pages_a_afficher($page, ceil($count/15), 3)
    ));
}

?>