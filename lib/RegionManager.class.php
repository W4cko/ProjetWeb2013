<?php

/**
 * Gère les régions
 *
 * @author MK
 */
class RegionManager {

    /**
     * Renvoie toutes les regions
     * @return array Tableau de Region
     */
    public function all() {
        global $db_projet;

        $sql = "SELECT code,nom,cl_dept,cl_rang
                    FROM regions 
                        ORDER BY code ASC";

        $query = $db_projet->query($sql);
        $departements = array();
        while($res = $query->fetch()) {
            $departements[] = new Region(array(
                'code' => $res['code'],
                'nom' => $res['nom'],
                'cl_dept' => $res['cl_dept'],
                'cl_rang' => $res['cl_rang']
            ));
        }
        return $departements;
    }

    /**
     * Renvoie l'INSEE du chef lieu de la région
     * passée en paramètre
     * @param int $code Code de la région
     * @return int Le code INSEE du chef lieu
     */
    public function chef_lieu($code) {
        global $db_projet;

        $sql = 'SELECT cl_dept||cl_comm AS insee 
                    FROM regions 
                        WHERE code = :code';

        $query = $db_projet->prepare($sql);
        $query->execute(array('code' => $code));
        $res = $query->fetch();
        return $res['insee'];
    }
}

?>