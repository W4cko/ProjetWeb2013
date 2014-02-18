<?php
/**
 * Template pour la page de connexion
 *
 * @author MK
 */
?> 

    <section id="wrap">
        <div class="titre">
            <h1>Connexion</h1>
        </div>
        <div class="inner">

            <section id="membre">
                <form method="post" action="" id="formulaire">
                    <div class="item">
                        <label for="login">Login</label>
                        <input type="text" id="login" name="login" required="required" />
                    </div>
                    <div class="item">
                        <label for="pass">Mot de passe</label>
                        <input type="password" id="pass" name="pass" required="required" />
                    </div>
                    <div class="go">
                        <input type="submit" name="" value="Go" />
                    </div>
                </form>
            </section> <!-- #membre -->

        </div> <!-- .inner -->
    </section> <!-- #wrap -->
    <script src="js/formulaire_connexion_inscription.js"></script>