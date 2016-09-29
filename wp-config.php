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
define('WP_MEMORY_LIMIT', '64M');
 
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'saarthak');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Saarthak@1235');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'F,/$|]B:|LCc@-[{QmM+`+):*=@*RoImF-BExc^?4&@H) Czg$?T@NFWrm}T_MMo');
define('SECURE_AUTH_KEY',  'br(GnG{3.uZ?j5&}K[u=BNRe#2nA[+kP5qZwVFg[%GBN:?sxXp~W>#HTr#VZEodM');
define('LOGGED_IN_KEY',    'PiE=kw})5pPoqNShS |aF6)Gy-*0A+2IpJd!1j[N9~ (G|,ShKG[Jw[LB68ESEZ8');
define('NONCE_KEY',        '%BK79r~oGg=p^j2dRvBnejMFB]~LCbVN4LZpa%J$5@p5@k9H{zP09L5oqYFx<6q ');
define('AUTH_SALT',        'iP7%M=?.>5=KJAUdrvoRF1:>i+[MH/w^n7qWLq&S><#?&99:*@v&(-zR7!W.p-EW');
define('SECURE_AUTH_SALT', 'N]-r>s/^c~8]foefy|[eMB~ufdNee#(p-[EeqIp7&s-do<+;sdbiVxOROa1J>UCm');
define('LOGGED_IN_SALT',   'I(&H+e;v.iZ?svn_vgc+^y|vef1TqdaOdfB|bLK7J?/af:-i^#i$++eoG>Ox*/42');
define('NONCE_SALT',       '_!H)0Wv=wH%16L.G:FAe|$bFz7lN`qXr<@)y3BMYlt-.3ddE2S8?8&42UMlW;-@)');
define('FS_METHOD', 'direct');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sr_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
