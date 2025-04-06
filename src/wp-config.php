<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

//definir endereco do site
define('WP_HOME','http://localhost:8080');
define('WP_SITEURL','http://localhost:8080');

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'marcusfontoura_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'db:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'mz^w(lAzvKOfe?;=q]y~AEsl0c30*bd-G]C&=o??e.<G|caa)J.^~W+GU;<B+uD>' );
define( 'SECURE_AUTH_KEY',  ' Iu/i8S9s4/JIiR!7~$C6?Duhg!PR;xL_ 951!T}W^8Xi4h!2_g CC:^KB`}vtXD' );
define( 'LOGGED_IN_KEY',    '*%?{$5@|#rHET%/L{|LG V.2M3y`uf@7Rt&J0@.3VqVDoFstf$3&)+b(#9zRsCd`' );
define( 'NONCE_KEY',        '|}^Ekf2(8:3=yb hBT: &s*L6d_!]ewi,d|`2.B!@4ZWS9fTXAtf0*J8fN+mY</8' );
define( 'AUTH_SALT',        'OY.|bHd >UF.(!h:jIQLviDaq1w,/73^&O,ONECx&AeKK[gF2/;^953#F~(:67#<' );
define( 'SECURE_AUTH_SALT', 'A/cFa5gMg]Foj39DrHtp[=#<F`pld0DKF7_~<$tD@%Y{Q%EaD&?U6t/NGCd:V_HG' );
define( 'LOGGED_IN_SALT',   'l~0 b)?uIRez4ZabDh7dPVt1T[gIb0hn_-Hghlm.B}OMNO!?5&EYem-@02zUTmq#' );
define( 'NONCE_SALT',       '#>5qPmkc7-5xD0@U8(nh5xM*uAQ`0n^utM (})STm3aBRZ@7I=mgY[%V-W`Ho(< ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
