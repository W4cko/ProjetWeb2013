<?php

/**
 * Page d'index
 *
 * @author MK
 */

require_once 'common.php';

// Managers
$DepartementManager = new DepartementManager();
$RegionManager = new RegionManager();

// Données
$departements = $DepartementManager->all();
$regions = $RegionManager->all();

// Affichage du template
$template->affiche('accueil', array(
    'titre_page' => 'Rechercher une commune',
    'regions' => $regions,
    'departements' => $departements
));
?>