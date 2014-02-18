<?php

/**
 * Représente un département
 *
 * Utilisantion d'un tableau pour stocker les données, plutot que une 
 * variable pour chaque donnée avec un getter et un setter pour chacune, 
 * pour plus de flexibilité (code plus rapide à modifier si on veut add une donnée)
 * Et objet plus simple à instancier, il suffit de passer un tableau associatif en paramètre
 *
 * @author MK
 */
class Departement {

    /**
     * Tableau des données
     */
    private $donnees;

    /**
     * Tableau des clés valides pour les données
     */
    const CLES_VALIDES = 'code,nom,cl_dept,cl_comm,region,tncc';

    /**
     * Construit un departement
     * @param array $donnees Donnes du departement
     */
    public function __construct(array $donnees = array()) {
        $differences = array_diff(array_keys($donnees), explode(',', self::CLES_VALIDES));
        if(!empty($differences)) {
            throw new DonneesIncorrectesException("Departement : données incorrectes");
        } else {
            $this->donnees = $donnees;
        }
    }

    /**
     * Renvoie une information du departement
     * @param string $cle Nom de l'information voulue
     * @return mixed La valeur de la clé si elle existe, null sinon
     */
    public function get($cle) {
        if(isset($this->donnees[$cle])) {
            return $this->donnees[$cle];
        } else {
            return null;
        }
    }
}

?>