<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 21.08.2019
 * Time: 11:30
 */



//Меняем url у хлебных крошек, чтобы они вели не на страницы, а передавали параметры фильтру
add_filter( 'woocommerce_get_breadcrumb', 'change_breadcrumbs_url', 10, 2 );
function change_breadcrumbs_url( $crumbs, $this_arg ) {
    //Перебираем все $crumbs по отдельности
    $k = count($crumbs);
    for ($i = 0; $i < $k; $i++) {
        if ($i == 0) continue; //Первый не учитывается
        if ($i == $k-1) continue; //Последний - тоже (он все равно без ссылки)
        if(isset($crumbs[$i][1]) && strlen($crumbs[$i][1])>0) {
            $crumbUrl = $crumbs[$i][1];

            //Если последний символ /, отрезаем его
            if (substr($crumbUrl, -1) == '/') {
                $crumbUrl = substr($crumbUrl, 0, -1);
            }

            //Если в url есть /product-category/, то продолжаем
            if (strpos($crumbUrl, '/product-category/') !== false) {

                //Разбиваем строку по разделителю /, и берем последний с конца
                $units = explode("/", $crumbUrl);
                $lastUnit = $units[count($units) - 1];

                $newUrl = '/shop/?swoof=1&product_cat=' . $lastUnit;

                $crumbs[$i][1] = $newUrl;
            }
        }
    }



    return $crumbs;
}
