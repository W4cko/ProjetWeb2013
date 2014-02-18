<?php

/**
 * Gère la connexion des membres
 *
 * @author MK
 */
class Authentification {

    /**
     * Nom la clé de session qui va contenir les infos de l'utilisateur
     */
    const SESSION = 'ident';

    /**
     * True si l'utilisateur est connecté, false sinon
     */
    private $connecte;

    /**
     * Constructeur
     */
    public function __construct() {
        if(isset($_SESSION[self::SESSION])) {
            $this->connecte = true;
        } else {
            $this->connecte = false;
        }
    }

    /**
     * Verifie si le login et le mot de passe fourni correspondent
     * à un utilisateur inscrit, si oui il devient connecté
     * @param string $login Le login
     * @param string $pass le mot de passe
     * @return boolean True si les identifiants sont corrects, false sinon
     */
    public function verifieIdentifiants($login, $pass) {
        $UserManager = new UserManager();
        $user = $UserManager->verifie($login, $pass);
        if($user == null) {
            return false;
        } else {
            $this->connecte = true;
            $_SESSION[self::SESSION] = $user;
            return true;
        }
    }

    /**
     * Deconnecte l'utilisateur
     */
    public function deconnecte() {
        $_SESSION = array();
        session_destroy();
    }

    /**
     * Verifie si l'utilisateur est connecté
     * @return boolean True si l'utilisateur est connecté, false sinon
     */
    public function est_connecte() {
        return $this->connecte;
    }

    /**
     * Renvoie les infos de l'utilisateur si il est connecté
     * @return mixed Un objet User si il est connecté, null sinon
     */
    public function get_infos() {
        if($this->est_connecte()) {
            return $_SESSION[self::SESSION];
        } else {
            return null;
        }
    }
}

?>