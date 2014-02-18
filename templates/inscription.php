<?php
/**
 * Template pour la page d'inscription
 *
 * @author MK
 */
?> 
    <section id="wrap">
        <div class="titre">
            <h1>Inscription</h1>
        </div>
        <div class="inner">

            <section id="membre">
                <form method="post" action="" id="formulaire">
                    <div class="item">
                        <label for="login">Login</label>
                        <input type="text" id="login" name="login" pattern="[a-zA-Z0-9]{3,50}" required="required" />
                    </div>
                    <div class="item">
                        <label for="pass">Mot de passe</label>
                        <input type="password" id="pass" name="pass" pattern=".{3,}" required="required" />
                    </div>
                    <div class="item">
                        <label for="passconf">Confirmation du mot de passe</label>
                        <input type="password" id="passconf" name="passconf" pattern=".{3,}" required="required" />
                    </div>
                    <div class="go">
                        <input type="submit" name="" value="Go" />
                    </div>
                </form>
            </section> <!-- #membre -->

        </div> <!-- .inner -->
    </section> <!-- #wrap -->
    <script src="js/formulaire_connexion_inscription.js"></script>