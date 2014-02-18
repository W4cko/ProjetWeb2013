/**
 * Messages d'erreurs pour les formulaires de connexion et d'inscription
 * Utilisation de fonctions anonymes pour ne pas polluer l'espace global
 *
 * @author MK
 */
window.addEventListener("load", function() {
    var f = document.getElementById("formulaire");
    f["login"].addEventListener("input", function() {
        if(this.validity.patternMismatch) {
            this.setCustomValidity("Minimum 3 caractères, 50 maximum, caractères alphanumériques");
        } else {
            this.setCustomValidity("");
        }
    }, false);
    f["pass"].addEventListener("input", function() {
        if(this.validity.patternMismatch) {
            this.setCustomValidity("Minimum 3 caractères");
        } else {
            this.setCustomValidity("");
        }
    }, false);
    f["passconf"].addEventListener("input", function() {
        var pass = f["pass"].value;
        if(this.value != pass) {
            this.setCustomValidity("Doit être identique au mot de passe ci-dessus");
        } else {
            this.setCustomValidity("");
        }
    }, false);
}, false);