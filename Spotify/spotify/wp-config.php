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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'crmdfur_spotify' );

/** Database username */
define( 'DB_USER', 'crmdfur_spotify' );

/** Database password */
define( 'DB_PASSWORD', 'XBSfrI3LNMH2' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'XgdRN<,KglCC*uz1fQ$w~sp-n#j&_& 9([zQ]Y.C8?6z&;HMKLCppk=f5?p1}??Y' );
define( 'SECURE_AUTH_KEY',  'pr;V{1db~zq@KoidmG=eBTb=h?n|LYF/SUls0{pIGBsONI*!FZz[A%LORoG):u]d' );
define( 'LOGGED_IN_KEY',    'o`H}JV=N!_1EG1Qfiw[YJEtlk<y64}8%H5tqp]!&$$P`<Rm:0`^NR*~|rFJ9$89B' );
define( 'NONCE_KEY',        '9w?F(:5)]MBbR1Rr6B#7<}D+}AymCb-cR@l6robk[|[m3@u6KQR43kICGu-0gnrx' );
define( 'AUTH_SALT',        'A:FzhLbG4y*PCf-3zr=I&H>ob_]}f0QdBNKxNii9Y}8u(zE$Wc5oJO!y`YA|BZS`' );
define( 'SECURE_AUTH_SALT', 'z$FTq |[Kv9G*Qj4oBM/b<{uS/}(|tT|}ebv>M|Z@e{@%(P|%n*OylNn|Z{UIHm4' );
define( 'LOGGED_IN_SALT',   'Hn&2/4X.x%ax?amM1 3G..t*}Ir_vkOv|_`AgmGSgUN  8@q?(I/7Afy6cu`R=^Y' );
define( 'NONCE_SALT',       'STG,OL*C/PCceBzc;d0S1d:hhi]7l:h1qcW1/RqXyI%VCeMssc/hJzxp5{Je/f#f' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
