<?php
/**
 * Template pour la page des détails d'une commune
 *
 * @author MK
 */
?> 

    <section id="wrap">
        <div class="titre">
            <h1>
                <?php echo tncc($tncc, 'a') . $nom; ?>
                <?php
                if($complement != null) {
                    echo '<span class="compl">'.$complement.'</span>';
                }
                ?>
            </h1>
            <a href="<?php echo $lien_favoris; ?>" id="fab-btn">
                <?php echo ($est_favoris) ? '-' : '+' ?>
                Favoris
            </a>
        </div>
        <div class="inner clearfix">

            <section id="details">
                <table>
                    <tr>
                        <td class="gr">Région</td>
                        <td>
                            <?php echo $region_nom; ?>
                            <?php if($est_cl_reg): ?> (Chef-lieu) <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="gr">Département <?php echo tncc($departement_tncc, 'c'); ?></td>
                        <td>
                            <?php echo $departement_nom; ?>
                            <?php if($est_cl_dpt): ?> (Chef-lieu) <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="gr">Population</td>
                        <td><?php echo $population; ?></td>
                    </tr>
                    <tr>
                        <td class="gr">Latitude</td>
                        <td><?php echo $latitude; ?></td>
                    </tr>
                    <tr>
                        <td class="gr">Longitude</td>
                        <td><?php echo $longitude; ?></td>
                    </tr>
                </table>

            </section> <!-- #details -->

            <aside id="map">
                <div id="lacarte"></div>
                <?php if($retour_vers_liste_resultats): ?>
                    <div id="back">
                        <a href="<?php echo $retour_vers_liste_resultats; ?>">Retour vers les résultats</a>
                    </div>
                <?php endif; ?>
            </aside> <!-- #map -->

            <div id="blank">
                &nbsp;
            </div> <!-- #blank -->

        </div> <!-- .inner -->
    </section> <!-- #wrap -->

    <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
    <script src="js/map.js"></script>
    <script type="text/javascript">
        var coord = new OpenLayers.LonLat(<?php echo $longitude; ?>, <?php echo $latitude; ?>);
        coord.transform(projSpherique,projCarte);
        var marker = new OpenLayers.Marker(coord);
        calqueMarkers.addMarker(marker);
        map.setCenter(coord,11);
    </script>