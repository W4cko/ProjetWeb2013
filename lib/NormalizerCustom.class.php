<?php

/**
 * Permet de transformer une chaine en une autre 
 * chaîne ASCII 7 bits, en majuscules, sans article
 *
 * @author MK
 */
class NormalizerCustom {

    /**
     * Regex utilisée pour 'sans_diacritiques_ni_ligatures'
     */
    const REG_DIAC_LIG = '/&([A-za-z]{1,2})(?:acute|breve|caron|cedil|circ|dblac|die|dot|grave|macr|ogon|ring|tilde|uml|lig);|(&)amp;/';

    /**
     * Regex pour les articles
     */
    const REG_ART = '/^((les|las|los|la|le) |l\')/i';

    /** 
     * Conversion d'une chaîne UTF-8 en ASCII 7bits 
     * - remplace un caractère avec diacritique par le caractère de base (ex : à -> a, ç -> c, Ü ->U ...)
     * - remplace un caractère ligaturé par les 2 caractères ASCII (ex : œ -> oe, Œ -> OE)
     * - les éventuels autres caractères UTF-8 sont remplacés par  leur entité XML/HTML
     * @param string $chaine La chaine a traiter
     * @return string La nouvelle chaine
     */
    private static function sans_diacritiques_ni_ligatures($chaine) {
        $chaine  = str_replace('&', '&amp;', $chaine);
        $chaine  = mb_convert_encoding($chaine, 'HTML-ENTITIES', 'UTF-8'); 
        $chaine = preg_replace(self::REG_DIAC_LIG, '\1\2', $chaine);
        return $chaine;
    }

    /**
     * Supprime l'article au début de la chaine
     * @param string $chaine La chaine a traiter
     * @return string La nouvelle chaine
     */
    private static function sans_articles($chaine) {
        return preg_replace(self::REG_ART, '', $chaine);
    }

    /**
     * Enlève les espaces en début/fin de la chaine et
     * remplace les autres par des '-'
     * @param string $chaine La chaine a traiter
     * @return string La nouvelle chaine
     */
    private static function sans_espaces($chaine) {
        $chaine = trim($chaine);
        $chaine = preg_replace('/ /', '-', $chaine);
        return $chaine;
    }

    /**
     * Convertit la chaine en majuscules
     * @param string $chaine La chaine a traiter
     * @return string La nouvelle chaine
     */
    private static function en_majuscule($chaine) {
        return mb_strtoupper($chaine, 'UTF-8');
    }

    /**
     * Permet de transformer une chaine en une autre 
     * chaîne ASCII 7 bits, en majuscules, sans article
     * @param string $chaine La chaine a traiter
     * @return string La nouvelle chaine
     */
    public static function normalize($chaine) {
        $chaine = self::sans_diacritiques_ni_ligatures($chaine);
        $chaine = self::en_majuscule($chaine);
        $chaine = self::sans_articles($chaine);
        $chaine = self::sans_espaces($chaine);
        return $chaine;
    }
}

?>