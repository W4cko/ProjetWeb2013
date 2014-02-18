/** 
 * Messages d'erreurs pour la recherche
 * Utilisation de fonctions anonymes pour ne pas polluer l'espace global
 *
 * @author MK
 */
window.addEventListener("load", function() {
    var f = document.getElementById("formulaire");
    f["popmin"].addEventListener("input", function() {
        if(this.validity.patternMismatch) {
            this.setCustomValidity("Entrez un chiffre");
        } else {
            this.setCustomValidity("");
        }
    }, false);
    f["popmax"].addEventListener("input", function() {
        if(this.validity.patternMismatch) {
            this.setCustomValidity("Entrez un chiffre");
        } else {
            this.setCustomValidity("");
        }
    }, false);
    f["insee"].addEventListener("input", function() {
        if(this.validity.patternMismatch) {
            this.setCustomValidity("Entrez un code INSEE valide (5 caractères)");
        } else {
            this.setCustomValidity("");
        }
    }, false);
}, false);