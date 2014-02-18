<?php

/*
 * Moteur de templates simplifié
 *
 * @author MK
 */
class Template {

    /**
     * Dossier des templates
     */
    const DOSSIER = 'templates/';

    /**
     * Charge un template
     * @param string $nom_template Nom du template
     * @param array $params Paramètres, variables qui seront disponibles
     *                      dans le template, pour etre affichées etc
     */
    public function affiche($nom_template, $params) {
        global $auth;

        // ici on "extrait" le tableau, cad que les clés deviennent
        // des variables qui contienent leurs valeurs associées
        extract($params);

        require self::DOSSIER . 'inc/header.php';
        require self::DOSSIER . $nom_template . '.php';
        require self::DOSSIER . 'inc/footer.php';
    }
}

?>