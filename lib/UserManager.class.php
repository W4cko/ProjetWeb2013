<?php

/**
 * Gère les utilisateurs
 *
 * @author MK
 */
class UserManager {

    /**
     * Verifie si un utilistauer existe déjà
     * @param string $login Le login a vérifier
     * @return boolean True si l'utilisatur existe, false sinon
     */
    public function existe($login) {
        global $db_projet; 
        $sql = 'SELECT COUNT(*) AS nb 
                    FROM membres 
                        WHERE login = :login';
        $query = $db_projet->prepare($sql);
        try {
            $query->execute(array('login' => $login));
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
        $query->execute(array('login' => $login));
        $res = $query->fetch();
        return $res['nb'] > 0;
    }

    /**
     * Ajoute un utilisateur
     * @param string $login Son login
     * @param string $pass Son mot de passe
     */
    public function add($login, $pass) {
        global $db_projet; 
        $sql = 'INSERT INTO membres (login,password) values (:login, :pass)';
        $query = $db_projet->prepare($sql);
        $query->execute(array(
            'login' => $login,
            'pass' => $pass
        ));
    }

    /**
     * Verifie le mot de passe
     * @param string $login Login
     * @param string $pass Mot de passe
     * @return mixed Les infos de l'utilisateur si les identifiants sont bons, null sinon
     */
    public function verifie($login, $pass) {
        global $db_projet;
        // les mots de mots sont hashés en md5 dans la bdd, pour un peu plus de sécurité
        $pass = md5($pass);
        $sql = 'SELECT id,login 
                    FROM membres 
                        WHERE login = :login 
                          AND password = :pass';
        $query = $db_projet->prepare($sql);
        $query->execute(array(
            'login' => $login,
            'pass' => $pass
        ));

        if($query->rowCount() == 0) {
            return null;
        } else {
            $res = $query->fetch();
            return new User(array(
                'id' => $res['id'], 
                'login' => $res['login']
            ));
        }
    }
}

?>