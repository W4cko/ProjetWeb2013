/**
 * Initialisation de la map
 *
 * @author MK
 */
var map = new OpenLayers.Map("lacarte");
map.addLayer(new OpenLayers.Layer.OSM());
var projCarte = map.getProjectionObject();
var projSpherique = new OpenLayers.Projection("EPSG:4326"); 
var calqueMarkers = new OpenLayers.Layer.Markers("Repères");
map.addLayer(calqueMarkers);