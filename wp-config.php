<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


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
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'dunga_football' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'dunga_football' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', ')8k3;V8Rkd' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'dunga.mysql.tools' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

define('AUTH_KEY',         'VCgq1iB;H|H0pl]zGR5Aa5!@r;DY*-l@>&|(Mq;8#j]b>F6-]Y|v-0-+l#f.qPG!');
define('SECURE_AUTH_KEY',  '%bFT|dF-SZT/?W:q+!lWn.W.n1ywiY[hbA.R39TofREn!RG6DD&%?ZlN_#Z /2N,');
define('LOGGED_IN_KEY',    'S!4j3yN5/9S{Quvq)s/gsc`Vw (mi?(,8GTIP&N-^rn3p*i0}<.<}+~mw@-k]&}F');
define('NONCE_KEY',        '1pz[9Aa|(}54{]f^.YA.YjM3bE@mO|dZS2d ;WR~si{|yfQ>{Csp!D!!!p=tY,p;');
define('AUTH_SALT',        '|z}@v@Mv%}CPCTVdDztl3T_EjD.PLj0eY##{b|f%)Sn0om4KBQoFHMd9dV|~m,Ti');
define('SECURE_AUTH_SALT', 'J|H9a+VpR(bKa9F|Q7kr#k:RgQ8k7:c7^#pf{nnxPAU=Bx(X!2|*V<9|]DzY+o!o');
define('LOGGED_IN_SALT',   'ZHrcUioT|-BB`Sn`vA+n;|XeU 0vnZ^)O,!qA-FgI{FasIWkl-XmF?aVyZ60e}!H');
define('NONCE_SALT',       'k[u#->ujzq~Cr^;up/Ren*h~RMn&@Ukp|ef%~*P{rvps.dE%Rv7ikcjsrEcKX?/P');


/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';

