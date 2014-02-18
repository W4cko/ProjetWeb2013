<?php 

/**
 * Page de deconnexion
 *
 * @author MK
 */

require_once 'common.php';
$auth->deconnecte();
header('Location: index.php');
?>