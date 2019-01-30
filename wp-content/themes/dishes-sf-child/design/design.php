<?php


//Нужно подвинуть этот экшн ниже чтобы вставить перед ним header_top. Меняем ему порядок
add_action( 'storefront_header', 'replace_storefront_header_container', 1 );
function replace_storefront_header_container()
{
    remove_action('storefront_header', 'storefront_header_container', 0);
    add_action( 'storefront_header', 'storefront_header_container', 3 );
}



add_action( 'storefront_header', 'header_top', 2 );
function header_top() {
    ?>

    <div class="header-top">
        
        <div class="top-order">
            <p class="order1">Ordered before 17:30, shipped today  - Support: (012) 800 456 789</p>
            <p class="order2">Track Your Order</p>
        </div>


        <hr>
    </div>

    <?php
}

?>