<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'gb_tst102bd');

/** Имя пользователя MySQL */
define('DB_USER', 'gb_tst102bd');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'c2zfc8ezyu');

/** Имя сервера MySQL */
//define('DB_HOST', 'mysql93.1gb.ru');
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'W=MMnpI8lik@Pw{%~U]g#PuYuv#(b{CF,mWFSh*l{N=<m&0-N>(R<w_R47{VC^/8');
define('SECURE_AUTH_KEY',  'whR8qzSf;8,<Lguz,RtF#c`|O`ycZZz~ 0S-~w3JxfFtJUB>C?LTRem+pWTnCF+Y');
define('LOGGED_IN_KEY',    'EvYE~JuI%whc@$vo>Poh$!y-zo wN$5R od0P-#b>>{_B>3:7s(W!dlAHg],]AL+');
define('NONCE_KEY',        'eve,!w^Rre;&`s#=$.~N^BIkcV1R|3pB{f2o8c:#,0lUJ#Kw$uix9^qEb:wB4+Xp');
define('AUTH_SALT',        't&Gag8) G10w$ZX()`+X5wa/Wt_}O6T)^Veb6{j~U5Rj_h8I96013]ItgS9]c{>i');
define('SECURE_AUTH_SALT', '>=q -ivz@)NS>Vzh_veyFX:a2lcv3]s(2t,#:[N%c~r{fX|5#iokd|TF;!~a!^4G');
define('LOGGED_IN_SALT',   '_e3Mspq[pRuJC+HI&aHBW} 6>DrON#Ie0X$gz&nWXu%rwb&r6.he82G.%w}4s-9|');
define('NONCE_SALT',       '#P!7.NAe6~?E#^a9.z!s~${:?R1y^*@?RP]=%X?RM}g?o@*9y8 /o3IF>7C9w&hp');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'rb_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');


//define( 'SHOW_MYCRED_IN_WOOCOMMERCE', true );