<?php

/**
 * Représente une commune
 *
 * Utilisantion d'un tableau pour stocker les données, plutot que une 
 * variable pour chaque donnée avec un getter et un setter pour chacune, 
 * pour plus de flexibilité (code plus rapide à modifier si on veut add une donnée)
 * Et objet plus simple à instancier, il suffit de passer un tableau associatif en paramètre
 *
 * @author MK
 */
class Commune {

    /**
     * Tableau des données
     */
    private $donnees;

    /**
     * Tableau des clés valides pour les données
     */
    const CLES_VALIDES = 'nom,insee,region,departement,complement,tncc,population,latitude,longitude';

    /**
     * Construit une commune
     * @param array $donnees Donnes de la commune
     */
    public function __construct(array $donnees = array()) {
        $differences = array_diff(array_keys($donnees), explode(',', self::CLES_VALIDES));
        if(!empty($differences)) {
            throw new DonneesIncorrectesException("Commune : données incorrectes");
        } else {
            $this->donnees = $donnees;
        }
    }

    /**
     * Renvoie une information de la commune
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