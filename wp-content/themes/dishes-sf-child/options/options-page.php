<?php

// https://wp-kama.ru/id_3773/api-optsiy-nastroek.html

/**
 * Регистрируем страницу настроек плагина
 */
add_action('admin_menu', 'add_rollboxtheme_page');
function add_rollboxtheme_page(){
    add_options_page( 'RollBox. Настройки.', 'RollBox. Настройки', 'manage_options', 'rollbox_options', 'rollbox_options_page_output' );
}

function rollbox_options_page_output(){
    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>

        <form action="options.php" method="POST">
            <?php
            // скрытые защитные поля
            settings_fields( 'option_group' );

            // Секции с настройками (опциями). (section_id_1, ...)
            do_settings_sections( 'rollbox_page' );

            //Кнопка сохранить
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/**
 * Регистрируем настройки.
 * Настройки будут храниться в массиве, а не одна настройка = одна опция.
 */
add_action('admin_init', 'theme_settings');
function theme_settings(){
    // параметры: $option_group, $rollbox_options_array, $sanitize_callback
    register_setting( 'option_group', 'rollbox_options_array', 'sanitize_callback' );

    /*// параметры: $id, $title, $callback, $page
    add_settings_section( 'section_id_1', 'Основные настройки', '', 'rollbox_page' ); 

    // параметры: $id, $title, $callback, $page, $section, $args
    add_settings_field('primer_field1', 'Название опции', 'fill_primer_field1', 'rollbox_page', 'section_id_1' );
    add_settings_field('primer_field2', 'Другая опция', 'fill_primer_field2', 'rollbox_page', 'section_id_1' );*/


    // Регистрируем раздел
    add_settings_section( 'section_id_2', 'Общие настройки', '', 'rollbox_page' );

    // Регистрируем поля ввода
    add_settings_field('sanitary_day', 'Дата санитарного дня (Например, 31.01.2019)', 'fill_sanitary_day', 'rollbox_page', 'section_id_2' );
    add_settings_field('new_product_duration', 'Сколько дней после публикации продукт считается новым (Например, 14)', 'fill_new_product_duration', 'rollbox_page', 'section_id_2' );


    // Регистрируем раздел
    add_settings_section( 'section_id_3', 'Инстаграм', '', 'rollbox_page' );
    add_settings_field('sidebar_instagram_title', 'Заголовок инстаграм виджета', 'fill_sidebar_instagram_title', 'rollbox_page', 'section_id_3' );
    add_settings_field('sidebar_instagram_shortcode_id', 'ID шорткода галереи инстаграм плагина. Размещение в сайдбаре (Например, для шорткода [insta-gallery id="3"] - нужно ввести 3)', 'fill_sidebar_instagram_shortcode_id', 'rollbox_page', 'section_id_3' );
}

/*## Заполняем опцию 1
function fill_primer_field1(){
	$val = get_option('rollbox_options_array');
	$val = isset($val['input']) ? $val['input'] : null;
	?>
	<input type="text" name="rollbox_options_array[input]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

## Заполняем опцию 2
function fill_primer_field2(){
	$val = get_option('rollbox_options_array');
	$val = isset($val['checkbox']) ? $val['checkbox'] : null;
	?>
	<label><input type="checkbox" name="rollbox_options_array[checkbox]" value="1" <?php checked( 1, $val ) ?> /> отметить</label>
	<?php
}*/



## Заполняем опцию Дата санитарного дня
function fill_sanitary_day(){
    $val = get_option('rollbox_options_array');
    $val = isset($val['sanitary_day']) ? $val['sanitary_day'] : '31-01-2019';
    ?>
    <input type="date" name="rollbox_options_array[sanitary_day]" value="<?php echo str_replace(".", "-", esc_attr( $val )) ?>" style="width: 30%;" />
    <?php
}
## Заполняем опцию Сколько дней после публикации продукт считается новым
function fill_new_product_duration(){
    $val = get_option('rollbox_options_array');
    $val = isset($val['new_product_duration']) ? $val['new_product_duration'] : '14';
    ?>
    <input type="number" name="rollbox_options_array[new_product_duration]" value="<?php echo esc_attr( $val ) ?>" style="width: 30%;" />
    <?php
}

## Заполняем опцию заголовок инстаграм виджета
function fill_sidebar_instagram_title(){
    $val = get_option('rollbox_options_array');
    $val = isset($val['sidebar_instagram_title']) ? $val['sidebar_instagram_title'] : 'Instagram';
    ?>
    <input name="rollbox_options_array[sidebar_instagram_title]" value="<?php echo esc_attr( $val ) ?>" style="width: 30%;" />
    <?php
}
## Заполняем опцию ID шорткода галереи инстаграм плагина
function fill_sidebar_instagram_shortcode_id(){
    $val = get_option('rollbox_options_array');
    $val = isset($val['sidebar_instagram_shortcode_id']) ? $val['sidebar_instagram_shortcode_id'] : '0';
    ?>
    <input type="number" name="rollbox_options_array[sidebar_instagram_shortcode_id]" value="<?php echo esc_attr( $val ) ?>" style="width: 30%;" />
    <?php
}

## Очистка данных
function sanitize_callback( $options ){
    // очищаем
    foreach( $options as $key => $value ){
        // Проверка на то, имеет текущая опция значение или нет. Если да, то обрабатываем её
        if( isset( $options[$key] ) ) {

            // Вырезаем все HTML- и PHP-теги, а также правильным образом обрабатываем строки в кавычках
            $options[$key] = strip_tags( stripslashes( $options[ $key ] ) );



            if( $key == 'sanitary_day' ){
                $options[ $key ]  = str_replace("-", ".", $value );
            }
            if( $key == 'new_product_duration' ){
                $options[ $key ]  = intval( $value );
            }

            if( $key == 'sidebar_instagram_title' ){
                $options[ $key ]  = $value;
            }
            if( $key == 'sidebar_instagram_shortcode_id' ){
                $options[ $key ]  = intval( $value );
            }


        }
    }

    //die(print_r( $options )); // Array ( [input] => aaaa [checkbox] => 1 )

    return $options;
}
