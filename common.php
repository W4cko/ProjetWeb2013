<?php

/**
 * Initialisations
 *
 * @author MK
 */

// Includes
require_once 'config.php';
require_once 'lib/functions.php';

// Autoload
spl_autoload_register('autoload');

// Session
session_start('pgdfg');

// Base de données projet
try {
    $db_projet = new PDO('pgsql:host='.DB_PROJET_HOST.';dbname='.DB_PROJET_DATABASE, DB_PROJET_USER, DB_PROJET_PASS, array(
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));
} catch(PDOException $e) {
    echo $e->getMessage();
    exit();
}

// Base de données perso
/*try {
    $db_perso = new PDO('pgsql:host='.DB_PERSO_HOST.';dbname='.DB_PERSO_DATABASE, DB_PERSO_USER, DB_PERSO_PASS, array(
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));
} catch(PDOException $e) {
    echo $e->getMessage();
    exit();
}*/

// Moteur de templates
$template = new Template();

// Système dauthentification
$auth = new Authentification();

// Si l'utilisateur est connecté on récupère ses infos
if($auth->est_connecte()) {
    $user = $auth->get_infos();
}

?>