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

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $_ENV['DB_NAME'] ?: '' );

/** MySQL database username */
define( 'DB_USER', $_ENV['DB_USER'] ?: '' );

/** MySQL database password */
define( 'DB_PASSWORD', $_ENV['DB_PASS'] ?: '' );

/** MySQL hostname */
define( 'DB_HOST', $_ENV['DB_HOST'] ?: 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'w3+22fLQk5R@<{G!L>;BC8gI$5sEFr4~04eEgGkJc6v(9v$pcukBjjwWP@YgU:LC' );
define( 'SECURE_AUTH_KEY',  ';X>!oZXXUMu#K!X$|6Q@e~,$IHbW!;+;2ZM6=yPk8gM0qDy!rR@j=Iz,Z;S27Mv%' );
define( 'LOGGED_IN_KEY',    'cp$KiV94t1[dDjU3lWtyNbOVJZK0fgqXNPVlu9.sA^q`d!hF9^.m.ocJG,QG$]2y' );
define( 'NONCE_KEY',        '~W%?_6K`.1~n(1;lA#DyNJ$mJqbB03g)hZ5*<Xl4gluevKwZYK<2ZWVN[ j+L8B5' );
define( 'AUTH_SALT',        '@<%M6dDpAKgjccF(CzFT[]R_}*%{,^NM)d-R~=);CO%m%*73BO pBG5T(2O<Yy7a' );
define( 'SECURE_AUTH_SALT', 'HnxNR2E|=FR+X(o1. z#Le4W7T:5fh4u_77p{{ZHkBj5tW+XPz<_eIPNlccvBH7V' );
define( 'LOGGED_IN_SALT',   'R%Yx9&,*qPoU>-;P/3O,Y_XdgQwFVc`@msfnh8}<6*y28e^_w6fYf2[;t[9y*)lT' );
define( 'NONCE_SALT',       'tIm$Q;XL@(WjQ=VO(GZO_ldB1Iz9g=RuoX=UE+T|646rH2fZR+[s0J>+9D@^7Yoj' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
