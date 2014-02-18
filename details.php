<?php

/**
 * Détails d'une commune
 *
 * @author MK
 */

require_once 'common.php';

$CommuneManager = new CommuneManager();

$insee = (isset($_GET['insee']) && strlen($_GET['insee']) == 5) ? $_GET['insee'] : null;

if($insee == null) {
    $template->affiche('message', array(
        'titre_page' => 'INSEE incorrect',
        'message_titre' => 'INSEE incorrect',
        'message_contenu' => 'Le code INSEE n\'est pas du bon format, veuillez réessayer.'
    ));
} else {

    try {
        $infos = $CommuneManager->commune($insee);
    } catch(CommuneInexistanteException $e) {
        $template->affiche('message', array(
            'titre_page' => 'Commune inexistante',
            'message_titre' => 'Commune inexistante',
            'message_contenu' => 'La commune demandée est incorrecte, veuillez réessayer.'
        ));
        exit();
    }

    if($auth->est_connecte()) {
        $FavorisManager = new FavorisManager($user->get('id'));
        $est_favoris = $FavorisManager->est_favorite($insee);
    } else {
        $est_favoris = false;
    }

    $lien_favoris = ($est_favoris) ? 
                        'fav.php?action=del&amp;insee='.$insee:
                        'fav.php?action=add&amp;insee='.$insee;

    // chef lieu
    $DepartementManager = new DepartementManager();
    $RegionManager = new RegionManager();
    $cl_dpt = $DepartementManager->chef_lieu($infos->get('departement')->get('code'));
    $cl_reg = $RegionManager->chef_lieu($infos->get('region')->get('code'));

    $template->affiche('details', array(
        'titre_page' => tncc($infos->get('tncc'), 'a').$infos->get('nom').' ('.$infos->get('insee').')',
        'region_nom' => $infos->get('region')->get('nom'),
        'departement_nom' => $infos->get('departement')->get('nom'),
        'departement_tncc' => $infos->get('departement')->get('tncc'),
        'population' => $infos->get('population'),
        'latitude' => $infos->get('latitude'),
        'longitude' => $infos->get('longitude'),
        'insee' => $infos->get('insee'),
        'tncc' => $infos->get('tncc'),
        'nom' => $infos->get('nom'),
        'complement' => $infos->get('complement'),
        'est_favoris' => $est_favoris,
        'lien_favoris' => $lien_favoris,
        'est_cl_dpt' => $cl_dpt == $infos->get('insee'), // chef du departement ?
        'est_cl_reg' => $cl_reg == $infos->get('insee'), // chef lieu de la region ?
        // On utilise le referer pour afficher un lien de retour vers la liste des résultats comme
        // demandé dans le sujet, non pas les sessions pour stocker le lien, car le referer est fait pour ça
        // on affiche le lien ssi la page précédente est la page des resultats
        'retour_vers_liste_resultats' => (isset($_SERVER['HTTP_REFERER']) && preg_match('/recherche\.php/', $_SERVER['HTTP_REFERER'])) ? 
                                                $_SERVER['HTTP_REFERER'] :
                                                false
    ));
}

?>