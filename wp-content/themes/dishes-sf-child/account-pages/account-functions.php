<?php

// Убираем лишние пункты меню в аккаунте
add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
function misha_remove_my_account_links( $menu_links ){

    //unset( $menu_links['edit-address'] ); // Addresses
    //unset( $menu_links['dashboard'] ); // Dashboard
    //unset( $menu_links['payment-methods'] ); // Payment Methods
    //unset( $menu_links['orders'] ); // Orders
    unset( $menu_links['downloads'] ); // Downloads
    //unset( $menu_links['edit-account'] ); // Account details
    //unset( $menu_links['customer-logout'] ); // Logout

    return $menu_links;
}





// Добавляем новый пункт меню
/*
 * Step 1. Add Link to My Account menu
 */
add_filter ( 'woocommerce_account_menu_items', 'add_more_link_to_account' );
function add_more_link_to_account( $menu_links ){

    // we will hook "rewards" later
    $new = array( 'rewards' => 'Бонусы' );

    // or in case you need 2 links
    // $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );

    // array_slice() is good when you want to add an element between the other ones
    $menu_links = array_slice( $menu_links, 0, 1, true )
        + $new
        + array_slice( $menu_links, 1, NULL, true );

    return $menu_links;
}
/*
 * Step 2. Register Permalink Endpoint
 */
/*add_filter( 'woocommerce_get_endpoint_url', 'add_more_hook_endpoints', 10, 4 );
function add_more_hook_endpoints( $url, $endpoint, $value, $permalink ){

    if( $endpoint === 'rewards' ) {

        // ok, here is the place for your custom URL, it could be external
        $url = get_permalink( get_option('woocommerce_myaccount_page_id') ) . 'rewards/';

    }
    return $url;
}*/
add_action( 'init', 'add_more_hook_endpoint' );
function add_more_hook_endpoint() {

    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint( 'rewards', EP_PAGES );

}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_rewards_endpoint', 'my_account_rewards_endpoint_content' );
function my_account_rewards_endpoint_content() {

    // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
    //класс страницы rewards
    require_once( get_stylesheet_directory() . '/account-pages/rewardsPage.php' );
    rewardsPage::getContent();

}
/*
 * Step 4
 */
// Go to Settings > Permalinks and just push "Save Changes" button.