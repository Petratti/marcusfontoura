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
define('WP_HOME','https://fontoura.org');
define('WP_SITEURL','https://fontoura.org');

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'marcusfontoura_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'tpcvN@EL2EC1' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         '2@OvbS|*UPq*k{l9Cz zm1S+B`eJGY4$!/Bm%=B#41NZ$B9aBdCig-Lj)&avgx{D');
define('SECURE_AUTH_KEY',  'JS2BaT5f+=CGj9lQFH7Zn]Z@P]hH~G~Ny7=k+i.,lg26&,K,| e{9|FH!D9ZU-U]');
define('LOGGED_IN_KEY',    'jMkiz(Ua(@kB+#kN+7^+l0]@BY=him)&Lt&$Xuqy*k7c>$>osPP/}AbBG7%5|yK3');
define('NONCE_KEY',        'x85dJlgXP<@G,F3Tv7T|2&}C.H,ps! )@v{CG;tnF%Cu+c9L*%6B7N:CDcH&@{|.');
define('AUTH_SALT',        '<a]+Bcecg9TiM(SYg*taI*7_KC/@imB#4NC:-x)A3E4RP(Q#L2@3Fv ToXEN)1lP');
define('SECURE_AUTH_SALT', '$aTV/,Xm:}raEOit|8t&RVx&0+yy+>=A).H8^LO=:$&;+1fCHG)5*R2`bN^p(=Y(');
define('LOGGED_IN_SALT',   'u/erdKvFboch7+$<VXwlU,U7.m<Ui)5YXq+qH8a<mu_OA?X$-8<Jjplw=$;i3}KQ');
define('NONCE_SALT',       'nyXC3/o>Xwr,wgH+P/+JE8dI#2E1x|c{s?9qkuQ~6,~(3vQ{u-7Y<wukdIfu]X_r');

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
define('FS_METHOD', 'direct');
define('WP_MEMORY_LIMIT', '256M');

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
