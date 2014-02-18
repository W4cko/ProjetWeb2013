<?php
/**
 * Template pour la page de recherche
 *
 * @author MK
 */
?> 
    <section id="wrap">
        <div class="titre">
            <h1>Résultats <i>(<?php echo $nombre; ?>)</i></h1>
        </div>
        <div class="inner">

            <section id="liste">
                <ul>
                    <?php
                    foreach ($resultats as $res) {
                        ?>
                            <li>
                                <article>
                                    <div class="insee"><?php echo $res->get('insee'); ?></div>                                    
                                    <h2>
                                        <a href="details.php?insee=<?php echo $res->get('insee'); ?>">
                                            <?php echo tncc($res->get('tncc'), 'a').$res->get('nom'); ?>
                                            <?php
                                            if($res->get('complement') != null) {
                                                echo '<span class="compl">'.$res->get('complement').'</span>';
                                            }
                                            ?>
                                        </a>
                                    </h2>
                                    <div class="bottom clearfix">
                                        <div class="dep"><?php echo $res->get('departement')->get('nom'); ?></div>
                                        <div class="coord">
                                            Latitude: <?php echo $res->get('latitude'); ?>
                                            &bull; 
                                            Longitude: <?php echo $res->get('longitude'); ?>
                                        </div>
                                    </div>
                                </article>
                            </li>
                        <?php
                    }
                    ?>
                </ul>
            </section> <!-- #liste -->

            <aside id="map">
                <div id="lacarte"></div>
            </aside> <!-- #map -->

            <nav id="pagination">
                <ul>
                    <?php
                    foreach ($pages_a_afficher as $p) {
                        if($p == null) {
                            echo '<li class="vide">...</li>';
                        } elseif($p == $page) {
                            echo '<li><a href="'.$url_sans_page.'&amp;page='.$p.'" class="courrante">'.$p.'</a></li>';
                        } else {
                            echo '<li><a href="'.$url_sans_page.'&amp;page='.$p.'">'.$p.'</a></li>';
                        }
                    }
                    ?>
                </ul>
            </nav> <!-- #pagination -->

        </div> <!-- .inner -->
    </section> <!-- #wrap -->

    <script src="js/liste.js"></script>
    <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
    <script src="js/map.js"></script>
    <script type="text/javascript">
        bounds = new OpenLayers.Bounds();
        <?php
        // Generation du javascript
        $i=0;
        foreach ($resultats as $res) {
            echo 'var coord'.$i.' = new OpenLayers.LonLat('.$res->get('longitude').','.$res->get('latitude').');';
            echo 'coord'.$i.'.transform(projSpherique,projCarte);';
            echo 'bounds.extend(coord'.$i.');';
            echo 'var marker'.$i.' = new OpenLayers.Marker(coord'.$i.');';
            echo 'calqueMarkers.addMarker(marker'.$i.');';
            $i++;
        }
        ?>
        map.zoomToExtent(bounds);
    </script>