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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'thecolombianway' );

/** MySQL database username */
define( 'DB_USER', 'tcw_user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'z03~pIJ6dsxeGrqf' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         't}5wBq-m $6>Y2P8yAqNEWE^/V~dA{Yr|hNr_3<9bC`n4B5WmA1>}|fI4B5/NR[O' );
define( 'SECURE_AUTH_KEY',  'BC~!Q%Li;y!-<eN`MOdv-@5TUw+k4M-SO9tQ(E;nFF}Z4gN~FL-}Bt%Y<AIwZnpN' );
define( 'LOGGED_IN_KEY',    't& OpPWG(<X:Y+/90{N9AA`zvzB&z%!3oM!_a3F$3DQdFHmK%ib]NNs$CUBT>N}R' );
define( 'NONCE_KEY',        'uhmhp|dfq;Ib?P#23cF#&Lkm.e6|E:xr?G)s!,%BBN?;?(6Qnsi$1dL@5G^-JM3Q' );
define( 'AUTH_SALT',        'p>*4-6Lo&Be*HhcZ[LrZBSBU^&&Y$]|]qDwPMxd_}hFZj|RN,shH+sWv-;Pi;Woc' );
define( 'SECURE_AUTH_SALT', 'j,2(R6D$4MqQ.,a}#JoW1mqd3)G^QkZGiEO2>[q2*Kw5!UOldeXdpIB~TBZO)hRq' );
define( 'LOGGED_IN_SALT',   'pZ~eb(L/B>+8z&|jnQ+GwGbWx*5{W]vgEsB7?IOuzD `{Znie LljN&%6,i^N@&2' );
define( 'NONCE_SALT',       'w9*t*p*r7<Do((v;q)HXEb0u^S#VFB^j(#FUZY[-Jw|t?UyP=2QkJ7`;ZQ4IdXfN' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
