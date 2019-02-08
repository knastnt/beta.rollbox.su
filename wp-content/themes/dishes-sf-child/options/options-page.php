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


    // Отправка корзины
    add_settings_section( 'section_id_2', 'Санитарный день', '', 'rollbox_page' );

    // URL для отправки POST
    add_settings_field('sanitary_day', 'Дата санитарного дня', 'fill_sanitary_day', 'rollbox_page', 'section_id_2' );
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



## Заполняем опцию Адрес для отправки POST
function fill_sanitary_day(){
    $val = get_option('rollbox_options_array');
    $val = isset($val['sanitary_day']) ? $val['sanitary_day'] : '31.01.2019';
    ?>
    <input type="text" name="rollbox_options_array[sanitary_day]" value="<?php echo esc_attr( $val ) ?>" style="width: 30%;" />
    <?php
}

## Очистка данных
function sanitize_callback( $options ){
    // очищаем
    foreach( $options as $name => & $val ){
        /*if( $name == 'input' )
            $val = strip_tags( $val );

        if( $name == 'checkbox' )
            $val = intval( $val );*/

        if( $name == 'send_new_orders_to_kristall' ){
            $val = intval( $val );
        }

        if( $name == 'sanitary_day' ){
            //$val = intval( $val );
        }
    }

    //die(print_r( $options )); // Array ( [input] => aaaa [checkbox] => 1 )

    return $options;
}