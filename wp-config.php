<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '3tsteaching_com');

/** MySQL database username */
define('DB_USER', '3tsteachingcom');

/** MySQL database password */
define('DB_PASSWORD', 'crvfzTWq');

/** MySQL hostname */
define('DB_HOST', 'wpdb.3tsteaching.com');

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
define('AUTH_KEY',         'SWU|~ukB##?z:~xtbovRuSm5hBz7Jl+T3X*AbmR%`V~f*OUCR7hW5oy~Y)1w*xCe');
define('SECURE_AUTH_KEY',  '"t(^"3:;#cpTE)#d+OpgoV^fCG*#IeKT:&:_ZEskJdqUUZxW+!Kw8);#C`+)mLWd');
define('LOGGED_IN_KEY',    ')?#|Iuel2nM6WVpp^aUcCcB`/(x`e!~@j_Y(t8e~v:M92f0yrO6?280OKmN3;Vfh');
define('NONCE_KEY',        'yE9GdsJx~P2x0IZGN^h)"aJKS1RT;yd)CN3rn1uodNMj)"ukiqucvH9YS1K&1rX0');
define('AUTH_SALT',        '6Sw_)$V`x&:0Ql1@5*;:(&md$1&GuY(z!7(tmgDW6pfkubW`+wUMwaG"n0b*~EBF');
define('SECURE_AUTH_SALT', '9G3Gu#a_%cs&WQ~T_|y?qMlFhe?$3g%RB/z$uaYAFu;ZpNUh(2vbR`M9D"vT?q(*');
define('LOGGED_IN_SALT',   '+B$MW55SJi8&x)!8BCwoN+Umi|d1Q"(nDf+Kg)dF^ekNi7R2#0BUeZc_hcM4^O`M');
define('NONCE_SALT',       '*Oh_VT?Hb#xZzTh6Na0FgZt*g%EKXR~3PJfS:&3_EG!Q^tq4!PIS3vfsh0R%cK5G');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_rvrrgb_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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

