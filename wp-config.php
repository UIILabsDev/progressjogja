<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'progressjogja');

/** MySQL database username */
define('DB_USER', 'homestead');

/** MySQL database password */
define('DB_PASSWORD', 'secret');

/** MySQL hostname */
define('DB_HOST', '192.168.10.10');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'mnFL_SU@3SGGb`kNvic-R&1.F+mmQ#ore7BZQT]`#uq0[#ET4Bx($6.FUih(!V<7');
define('SECURE_AUTH_KEY',  '5(vi+lwDu+zGp8+/o-`z]}]`L$zd26#<&1EbtV|C~YCyHFJrN*Pn&UX`eoWj-JI1');
define('LOGGED_IN_KEY',    'a.M omk0mZO;Bxi9G0Tc?+u!3wn2<!z+v&,^QgAfcCX,[IHR6JBvd{7Ce!]bOm1~');
define('NONCE_KEY',        '=GR]S9^>/U4r:C-=+?(NNW.8T2<J[_E+ i98-;-,t1<*G-l{vtEHjj4|LxU?U,Y8');
define('AUTH_SALT',        '}r9KiaWX`|.ZNn8rz$Rj~p]jizYU5uzLWH:|;?&_+GKD.KN26,M e+Q&+_tq=)[D');
define('SECURE_AUTH_SALT', '^0?k_,Dt0>eK!Z7,4~hMrEH@c30n)LC178haOjMhWI#Knkodgqkd&%H&2}JDs1r|');
define('LOGGED_IN_SALT',   '`N-Qk]),Dv_R>+0-+KotrN}h#]Y.=W$`]UtM>PvSu]rUyZ0iSH+z[tDH&^,@c0Hi');
define('NONCE_SALT',       'v=dK-X)U,;W_)1ypbW}L1[QwdB-fQ7InvS$yRKVgQF98TYlpoxcVsksz+~o6?lCQ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
