<?php

/**
 * Gère les départements
 *
 * @author MK
 */
class DepartementManager {

    /**
     * Renvoie tous les departements
     * @return array Tableau de Departement
     */
    public function all() {
        global $db_projet;

        $sql = "SELECT code,nom,cl_dept,cl_comm,region
                    FROM departements ORDER BY code ASC";

        $query = $db_projet->query($sql);
        $departements = array();
        while($res = $query->fetch()) {
            $departements[] = new Departement(array(
                'code' => $res['code'],
                'nom' => $res['nom'],
                'cl_dept' => $res['cl_dept'],
                'cl_comm' => $res['cl_comm'],
                'region' => $res['region']
            ));
        }
        return $departements;
    }

    /**
     * Renvoie l'INSEE du chef lieu du departement
     * passé en paramètre
     * @param int $code Code du département
     * @return int Le code INSEE du chef lieu
     */
    public function chef_lieu($code) {
        global $db_projet;

        $sql = 'SELECT cl_dept||cl_comm AS insee FROM departements 
                    WHERE code = :code';

        $query = $db_projet->prepare($sql);
        $query->execute(array('code' => $code));
        $res = $query->fetch();
        return $res['insee'];
    }
}

?>