<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 21.08.2019
 * Time: 11:30
 */

add_action( 'storefront_sidebar', 'addFloatApplyButton', 30 );

function addFloatApplyButton() {

    ?>
    <div id="floatApplyButton" style="display: none;">
        <button class="button woof_submit_search_form">Показать</button>
    </div>
    <?php

}