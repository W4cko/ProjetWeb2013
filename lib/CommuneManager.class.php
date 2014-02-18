<?php

/**
 * Gère les communes
 *
 * @author MK
 */
class CommuneManager {

    /**
     * Verifie si une commune existe
     *
     * @param string $insee Code INSEE de la commune
     * @return bool True si la commune existe, false sinon
     */
    public function existe($insee) {
        $count = $this->count(array('insee' => $insee));
        return $count;
    }

    /**
     * Renvoie le nombre de communes qui satisfont les
     * critères demandés
     *
     * @param array $criteres Tableau associatif de critères
     *                          - nom          :  Nom ASCII en majuscule
     *                          - insee        :  code insee
     *                          - region       :  code region
     *                          - departement  :  code departement
     *                          - popmin       :  population minimum
     *                          - popmax       :  population maximum
     * @return int Le nombre de communes
     */
    public function count($criteres) {
        global $db_projet;

        $criteres = array_merge(array(
            'nom' => null,
            'insee' => null,
            'region' => null,
            'departement' => null,
            'popmin' => null,
            'popmax' => null
        ), $criteres);

        $sql = "SELECT COUNT(*) AS nb FROM communes";
        $wheres = $this->criteres_sql($criteres);
        if($wheres != null) {
            $sql .= ' WHERE ' . $wheres;
        }

        // enlève les critères vides
        $criteres = array_filter($criteres);

        $query = $db_projet->prepare($sql);

        // evite d'utiliser des bindValue et sécurisé
        $query->execute(array_filter($criteres));

        $res = $query->fetch();
        return $res['nb'];
    }

    /**
     * Renvoie les communes qui satisfont les
     * critères demandés, et en fonction de la page voulue
     *
     * @param array $criteres Tableau associatif de critères
     *                          - nom          :  Nom ASCII en majuscule
     *                          - insee        :  code insee
     *                          - region       :  code region
     *                          - departement  :  code departement
     *                          - popmin       :  population minimum
     *                          - popmax       :  population maximum
     * @param int $page La page
     * @return array Tableau de 'Commune'
     */
    public function search($criteres, $page = 1) {
        global $db_projet;

        // on met les valeurs par defaut a null si
        // elles ne sont pas passées en paramètre
        $criteres = array_merge(array(
            'nom' => null,
            'insee' => null,
            'region' => null,
            'departement' => null,
            'popmin' => null,
            'popmax' => null
        ), $criteres);

        $sql = "SELECT dept||comm AS insee, 
                       communes.nom AS nom_commune,
                       departements.nom AS nom_departement, 
                       compl,
                       communes.tncc AS tncc_commune,
                       departements.tncc AS tncc_departement,
                       population, 
                       latitude, 
                       longitude,
                       LENGTH(nom_ascii_maj) AS taille
                    FROM communes,departements
                        WHERE communes.dept=departements.code";
        $wheres = $this->criteres_sql($criteres);
        if($wheres != null) {
            $sql .= ' AND ' . $wheres;
        }

        $sql .= " ORDER BY taille,nom_ascii_maj LIMIT 15 OFFSET " . ($page-1)*15;

        $query = $db_projet->prepare($sql);

        // enlève les critères vides
        $criteres = array_filter($criteres);

        // evite d'utiliser des bindValue et sécurisé
        $query->execute($criteres);
        $communes = array();
        while($res = $query->fetch()) {
            $communes[] = new Commune(array(
                'nom'           =>     $res['nom_commune'],
                'insee'         =>     $res['insee'],
                'tncc'          =>     $res['tncc_commune'],
                'complement'    =>     $res['compl'],
                'population'    =>     $res['population'],
                'latitude'      =>     $res['latitude'],
                'longitude'     =>     $res['longitude'],
                'departement'   =>     new Departement(array(
                                           'nom' => $res['nom_departement'],
                                           'tncc' => $res['tncc_departement']
                                       ))  
            ));
        }
        return $communes;
    }

    /**
     * En fonction des critères demandés, génère une partie de la requete SQL
     * Utilisé dans 'search' et 'count'
     *
     * @param array $criteres Tableau associatif de critères
     *                          - nom          :  Nom ASCII en majuscule
     *                          - insee        :  code insee
     *                          - region       :  code region
     *                          - departement  :  code departement
     *                          - popmin       :  population minimum
     *                          - popmax       :  population maximum
     * @return mixed Un portion de requete SQL (avec des  .... = .... [AND....]) ou null
     */
    private function criteres_sql($criteres) {

        // Si aucune critère, fin
        if(empty($criteres)) {
            return null;
        }

        // Contient les "...( = | > | < )...."
        $qualifications = array();

        // Nom
        if(!empty($criteres['nom'])) {
            $qualifications[] = "nom_ascii_maj LIKE '%'||:nom||'%'"; // on utilise || pour concaténer
        }

        // INSEE
        if(!empty($criteres['insee'])) {
            $qualifications[] = "dept||comm = :insee";
        }

        // Region
        if(!empty($criteres['region'])) {
            $qualifications[] = "communes.region = :region";
        }

        // Departement
        if(!empty($criteres['departement'])) {
            $qualifications[] = "dept = :departement";
        }

        // Population mini
        if(!empty($criteres['popmin'])) {
            $qualifications[] = "population >= :popmin";
        }

        // Population maxi
        if(!empty($criteres['popmax'])) {
            $qualifications[] = "population < :popmax";
        }

        // Rassemblement
        $sql = implode(' AND ', $qualifications);
        return $sql;
    }

    /**
     * Renvoie les informations d'une commune en fonction
     * de son code INSEE
     *
     * @throws CommuneInexistanteException Si $insee est inconnu
     * @param int $insee Code INSEE
     * @return mixed
     */
    public function commune($insee) {
        global $db_projet;

        $sql = "SELECT dept||comm AS insee, 
                       communes.nom AS nom_commune,
                       departements.nom AS nom_departement, 
                       regions.nom AS nom_region,
                       compl,
                       communes.tncc AS tncc_commune,
                       departements.tncc AS tncc_departement,
                       departements.code AS code_departement, 
                       regions.code AS code_region,
                       population, 
                       latitude, 
                       longitude
                    FROM communes,departements,regions 
                        WHERE communes.dept=departements.code
                            AND communes.region=regions.code
                            AND dept||comm = :insee";

        $query = $db_projet->prepare($sql);

        // evite d'utiliser des bindValue et sécurisé
        $query->execute(array('insee' => $insee));

        if($query->rowCount() == 0) {
            throw new CommuneInexistanteException();
        } else {
            $res = $query->fetch();
            return new Commune(array(
                'nom'           =>     $res['nom_commune'],
                'insee'         =>     $res['insee'],
                'tncc'          =>     $res['tncc_commune'],
                'complement'    =>     $res['compl'],
                'population'    =>     $res['population'],
                'latitude'      =>     $res['latitude'],
                'longitude'     =>     $res['longitude'],
                'region'        =>     new Region(array(
                                           'nom' => $res['nom_region'],
                                           'code' => $res['code_region']
                                       )),
                'departement'   =>     new Departement(array(
                                           'nom' => $res['nom_departement'],
                                           'tncc' => $res['tncc_departement'],
                                           'code' => $res['code_departement']
                                       ))  
            ));
        }
    }

    /**
     * Renvoie un tableau qui contient les informations de toutes les communes
     * dont les code INSEE sont passés en paramètre
     * 
     * @param array $insees Tableau de codes INSEE
     * @return array Tableau de communes
     */
    public function communes($insees) {
        global $db_projet;
        if(empty($insees)) {
            return array();
        }

        // On selectionne les communes par leur INSEE car le nom n'est pas
        // "forcement" unique, alors que le couple (dept, comm) est unique
        $sql = "SELECT DISTINCT dept||comm AS insee, 
                       communes.nom AS nom_commune,
                       departements.nom AS nom_departement,
                       compl, 
                       communes.tncc AS tncc_commune,
                       population, 
                       latitude, 
                       longitude
                    FROM communes,departements 
                        WHERE communes.dept=departements.code";
        $ands = array();
        foreach ($insees as $insee) {
            $ands[] = '(dept||comm = ?)';
        }
        $sql .= ' AND ('.implode(' OR ', $ands).')';

        $query = $db_projet->prepare($sql);
        $query->execute($insees);

        $communes = array();
        while($res = $query->fetch()) {
            $communes[] = new Commune(array(
                'nom'           =>     $res['nom_commune'],
                'insee'         =>     $res['insee'],
                'departement'   =>     $res['nom_departement'],
                'tncc'          =>     $res['tncc_commune'],
                'complement'    =>     $res['compl'],
                'population'    =>     $res['population'],
                'latitude'      =>     $res['latitude'],
                'longitude'     =>     $res['longitude']
            ));
        }
        return $communes;
    }
}

?>
