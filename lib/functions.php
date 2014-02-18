<?php

/**
 * Fonctions utilitaires
 *
 * @author MK
 */




/**
 * Autoload des classes
 * @param string $class Nom de la classe
 */
function autoload($class) {
    require_once $class . '.class.php';
}

/**
 * Renvoie un tableau des pages a afficher
 * @param int $page La page courrante
 * @param int $nb_page Nombre total de pages
 * @param int $nb Nombre de liens par "paquet"
 * @return array Tableau de pages (chiffres), un element peut valoir null
 *                  dans ce cas cela signifie une séparation de paquets de liens
 *                  (pour eviter d'avoir une pagination trop longue)
 */
function pages_a_afficher($page, $nb_page, $nb = 4) {
    $list_page = array();
    for ($i=1; $i <= $nb_page; $i++) {
        if (($i < $nb) || ($i > $nb_page - $nb) || (($i < $page + $nb) && ($i > $page -$nb)))
            $list_page[] = $i;
        else {
            if ($i >= $nb && $i <= $page - $nb)
                $i = $page - $nb;
            elseif ($i >= $page + $nb && $i <= $nb_page - $nb)
                $i = $nb_page - $nb;
            $list_page[] = null;
        }
    }
    return $list_page;
}

/**
 * Renvoie l'article ou la charnière pour le
 * code TNCC donné
 * @param int $tncc Le code TNCC
 * @param string $type 'a' pour article ou 'c' pour charnière
 * @return mixed L'article ou la charnière correspondant
 *                  OU null si erreur
 */
function tncc($tncc, $type) {
    $codes = array(
        0 => array('a' => '', 'c' => 'De '),
        1 => array('a' => '', 'c' => "D'"),
        2 => array('a' => 'Le ', 'c' => 'Du '),
        3 => array('a' => 'La ', 'c' => 'De La '),
        4 => array('a' => 'Les ', 'c' => 'Des '),
        5 => array('a' => "L'", 'c' => "De L'"),
        6 => array('a' => 'Aux ', 'c' => 'Des '),
        7 => array('a' => 'Las ', 'c' => 'De Las '),
        8 => array('a' => 'Los ', 'c' => 'De Los '),
    );

    return (isset($codes[$tncc][$type])) ? $codes[$tncc][$type] : null;
}
?>