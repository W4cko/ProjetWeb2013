<?php
/**
 * Template pour la page d'accueil
 *
 * @author MK
 */
?> 

    <section id="wrap">
        <div class="titre big">
            <h1>Rechercher</h1>
        </div>
        <div class="inner">

            <section id="search">

                <form method="get" action="recherche.php" id="formulaire">
                
                    <div class="gauche">

                        <div class="item">
                            <label for="nom">Commune</label>
                            <input type="text" id="nom" name="nom" />
                        </div>

                        <div class="item">
                            <label for="reg">Région</label>
                            <div class="select">
                                <select id="reg" name="reg">
                                    <option value="" selected></option>
                                    <?php
                                    foreach ($regions as $reg) {
                                        echo '<option value="'.$reg->get('code').'">'.$reg->get('code').' - '.$reg->get('nom').'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="item">
                            <label for="popmin">Population minimum</label>
                            <input type="text" id="popmin" name="popmin" pattern="[0-9]+" />
                        </div>

                    </div> <!-- .gauche -->

                    <div class="droit">

                        <div class="item">
                            <label for="insee">Code INSEE</label>
                            <input type="text" id="insee" name="insee" pattern="[0-9a-zA-Z]{5}" />
                        </div>

                        <div class="item">
                            <label for="dep">Département</label>
                            <div class="select">
                                <select id="dep" name="dep">
                                    <option value="" selected></option>
                                    <?php
                                    foreach ($departements as $dep) {
                                        echo '<option value="'.$dep->get('code').'">'.$dep->get('code').' - '.$dep->get('nom').'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="item">
                            <label for="popmax">Population maximum</label>
                            <input type="text" id="popmax" name="popmax" pattern="[0-9]+" />
                        </div>

                    </div> <!-- .droit -->

                    <div class="go">
                        <input type="submit" name="" value="Go" />
                    </div> <!-- .go -->

                </form>

            </section> <!-- #search -->

        </div> <!-- .inner -->
    </section> <!-- #wrap -->

    <script src="js/formulaire_recherche.js"></script>