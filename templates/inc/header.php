<?php
/**
 * Template pour le header du site
 *
 * @author MK
 */
?> 

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head>
    <meta charset="UTF-8">
 
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">

    <title><?php echo $titre_page; ?></title>
</head>
<body>

    <header id="header">
        <nav class="inner">
            <a href="index.php" id="logo">Communes</a>
            <ul id="toplinks">
                <?php if($auth->est_connecte()): ?>
                    <li><a href="favoris.php">Favoris</a></li>
                    <li><a href="deconnexion.php">Deconnexion</a></li>
                <?php else: ?>
                    <li><a href="inscription.php">Inscription</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header> <!-- #header -->