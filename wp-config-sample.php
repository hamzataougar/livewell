<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress');

/** MySQL database username */
define( 'DB_USER', 'root');

/** MySQL database password */
define( 'DB_PASSWORD', 'password');

/** MySQL hostname */
define( 'DB_HOST', 'mysql');

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8');

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':<-SMqMtz;|$Y 5bbqAZA+lh5)}D-@@si}%Mn95XL.DY-&tG>i{_dzni#!VN66do');
define('SECURE_AUTH_KEY',  'XLVu.|xd6WE641{X8pzLi.KGYW?@37NF:te]&::wb,_L9JAa>rDR?$.JL7^vjnp~');
define('LOGGED_IN_KEY',    'gw|20)z}`u.[/>/pMfXSLvc-zo(X1:M_[yVum%:+^)Gi5%dP7+2M.u_x{.=c-g0%');
define('NONCE_KEY',        '<0<~fV&|~`mo$QinRqczw&+0u#49/6N}AKQ>1zy]c%5`IeeMeHD3-t#://A,%]a+');
define('AUTH_SALT',        '>-_p>_r$<E}hD#>5~kKx7,6[NduEed$0c=+RRCE3pEVnRXgwF[W53UZ<=gMjw?2 ');
define('SECURE_AUTH_SALT', 'yM^t$]]k*0&Op?mnW6_Y4>-`QF_RBTth9n3Tk,W+ax,4btx_--IMSZ)^jhHMD]u9');
define('LOGGED_IN_SALT',   '0%2;_GY W|xftrFf@I>ar~#If`K8cEbJ78FO-{B^z,xY]Uh-x8_;|E-n>hg=TZ` ');
define('NONCE_SALT',       'e!-9bWM^-.{D&S7qL.m5>,`l*&-Tk66>RnlGZgVx<Z(j[H+nD9o|y0Od0P%!Q-@)');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpin_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once(ABSPATH . 'detect-mobile.php');

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
