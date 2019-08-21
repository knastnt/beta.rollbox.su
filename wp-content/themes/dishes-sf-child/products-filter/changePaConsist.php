<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 21.08.2019
 * Time: 11:30
 */



//Меняем url у ингридиентов из состава, чтобы они вели не на страницы, а передавали параметры фильтру
add_filter( 'term_link', 'change_pa_consist_url', 10, 3 );
function change_pa_consist_url( $termlink, $term, $taxonomy ) {
    //Перебираем все $crumbs по отдельности
//    $k = count($crumbs);
//    for ($i = 0; $i < $k; $i++) {
//        if ($i == 0) continue; //Первый не учитывается
//        if ($i == $k-1) continue; //Последний - тоже (он все равно без ссылки)
//        if(isset($crumbs[$i][1]) && strlen($crumbs[$i][1])>0) {
//            $crumbUrl = $crumbs[$i][1];
//
//            //Если последний символ /, отрезаем его
//            if (substr($crumbUrl, -1) == '/') {
//                $crumbUrl = substr($crumbUrl, 0, -1);
//            }
//
//            //Если в url есть /product-category/, то продолжаем
//            if (strpos($crumbUrl, '/product-category/') !== false) {
//
//                //Разбиваем строку по разделителю /, и берем последний с конца
//                $units = explode("/", $crumbUrl);
//                $lastUnit = $units[count($units) - 1];
//
//                $newUrl = '/shop/?swoof=1&product_cat=' . $lastUnit;
//
//                $crumbs[$i][1] = $newUrl;
//            }
//        }
//    }

    if ($taxonomy == 'pa_consist') {
        if(strlen($termlink)>0) {

            //Если последний символ /, отрезаем его
            if (substr($termlink, -1) == '/') {
                $termlink = substr($termlink, 0, -1);
            }

            //Если в url есть /consist/, то продолжаем
            if (strpos($termlink, '/consist/') !== false) {

                //Разбиваем строку по разделителю /, и берем последний с конца
                $units = explode("/", $termlink);
                $lastUnit = $units[count($units) - 1];

                $newUrl = '/shop/?swoof=1&pa_consist=' . $lastUnit;

                $termlink = $newUrl;
            }
        }
    }


    return $termlink;
}
