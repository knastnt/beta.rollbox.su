<?php


//Нужно подвинуть этот экшн перед ним storefront_header_container с нулевым приоритетом. это оказалось просто: приоритет -1
add_action( 'storefront_header', 'header_top', -1 );
function header_top() {
    ?>

    <div class="header-top">
        <div class="col-full">

            <div class="top-order">
                <p class="order1">Ordered before 17:30, shipped today  - Support: (012) 800 456 789</p>
                <p class="order2">Track Your Order</p>
            </div>

        </div>
    </div>

    <?php
}

