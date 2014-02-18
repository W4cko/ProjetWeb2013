<?php
/**
 * Template pour l'affichage d'un message d'erreur ou autre
 *
 * @author MK
 */
?> 
    <section id="wrap">
        <div class="titre">
            <h1><?php echo $message_titre; ?></h1>
        </div>
        <div class="inner">

            <section id="message">
                <?php echo $message_contenu; ?>
            </section> <!-- #message -->

        </div> <!-- .inner -->
    </section> <!-- #wrap -->