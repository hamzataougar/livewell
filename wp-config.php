<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'gzJPLGkhLXFWWIxYbn75z6bdrkLI5EEuKHO5taoZFqWtgTxFnqYCnlX5SN6vew73' );
define( 'SECURE_AUTH_KEY',  '1Ss9TGDZKqzK3zUlIv2mmTlmRoIgDtgHbg16muA0A4K98Weu47winXuAFvN3XUC2' );
define( 'LOGGED_IN_KEY',    'md6BeUQa62KqSNseQKidodqdgOjSKRRcGZKTuwsRtpjVYNpRtAhgrdLQv257rCvs' );
define( 'NONCE_KEY',        'kY10qx1yA67BicSSMMcAg2dwRVF5Zzd7FyU47AxtDQLqJCl2IKDRlbeRzhA2StO0' );
define( 'AUTH_SALT',        'Kwf1kLSTK1ExkSmYeRi1h4kuWZNmwRwgcNAqGzYiBk2DLvjt17rZpMUaKvUWHLPW' );
define( 'SECURE_AUTH_SALT', '0e0NPlU1QfNRBkCsewP40dQCRV05AW0Gjy4gSBdZzsLhmBoOmCCDy1U8GiD5Qks8' );
define( 'LOGGED_IN_SALT',   'mwWpHKQBlz0GTtX0WLLIP6GY7oNQsh9YaWOxl5tPBT4MNBgf7dDDpFOi1ksJPG9C' );
define( 'NONCE_SALT',       'dvpV4vCSk2vyS1Ugvb0rNmWfnl2foFbbI7G02rWOQk6geQKLBa0xQMydVGjMtMhU' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once(ABSPATH . 'detect-mobile.php');

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
