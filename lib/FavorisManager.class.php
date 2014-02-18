<?php 

/**
 * Permet de gérer les favoris
 *
 * @author MK
 */
class FavorisManager {

    /**
     * ID l'utilisateur
     */
    private $id;

    /**
     * Initialisation
     * @param int $id ID l'utilisateur
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * Renvoie le nombre de favoris
     * @return int le nombre de favoris
     */
    public function nb() {
        global $db_projet; 
        $sql = 'SELECT COUNT(*) AS nb FROM favoris WHERE membre = :id';
        $query = $db_projet->prepare($sql);
        $query->execute(array(
            'id' => $this->id
        ));
        $res = $query->fetch();
        return $res['nb'];
    }

    /**
     * Ajoute un favoris
     * @param int $insee L'insee de la commune
     */
    public function add($insee) {
        global $db_projet; 
        $sql = 'INSERT INTO favoris (membre,insee) VALUES (:membre, :insee)';
        $query = $db_projet->prepare($sql);
        $query->execute(array(
            'membre' => $this->id,
            'insee' => $insee
        ));
    }

    /**
     * Enlève un favoris
     * @param int $insee L'insee de la commune
     */
    public function del($insee) {
        global $db_projet; 
        $sql = 'DELETE FROM favoris 
                    WHERE membre = :membre 
                        AND insee = :insee';
        $query = $db_projet->prepare($sql);
        $query->execute(array(
            'membre' => $this->id,
            'insee' => $insee
        ));
    }

    /**
     * Vérifie si une commune est favorite
     * @param int $insee L'insee de la commune
     */
    public function est_favorite($insee) {
        global $db_projet; 
        $sql = 'SELECT COUNT(*) AS nb 
                    FROM favoris 
                        WHERE membre = :id 
                            AND insee = :insee';
        $query = $db_projet->prepare($sql);
        $query->execute(array(
            'id' => $this->id,
            'insee' => $insee
        ));
        $res = $query->fetch();
        return $res['nb'] > 0;
    }

    /**
     * Renvoie la liste des insees des communes favorites
     * @return array Tableau contenant les insee
     */
    public function get() {
        global $db_projet; 
        $sql = 'SELECT insee FROM favoris WHERE membre = :id';
        $query = $db_projet->prepare($sql);
        $query->execute(array(
            'id' => $this->id,
        ));
        $res = $query->fetchAll();
        $insees = array();
        foreach ($res as $r) {
            $insees[] = $r['insee'];
        }
        return $insees;
    }
}

?>