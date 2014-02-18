/**
 * Modifie la couleur de fond des listes de commune (resultats, favoris) lors d'un hover
 *
 * @author MK
 */
window.addEventListener("load", function(){
	var resultats = document.querySelectorAll("#liste li article");
	console.log(resultats);
	for(var i=0; i<resultats.length; i++) {
		resultats[i].addEventListener("click", function(){
			var lien = this.getElementsByTagName('a')[0].getAttribute('href');
			window.location.assign(lien);
		}, false);
	}
}, false);