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
define( 'DB_NAME', 'billing' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'E1-83!ZjbnF#0BLK%_T6vBa|:=aqJ>jkNgTFj-5$6wh^{n5yyC2KH&a~i[a:uI&4' );
define( 'SECURE_AUTH_KEY',  '9WNa75k;hU>*GDTw]BP!/@}Q.gBhA-N1if]~i^?*4i@#c[<@%K[_|&S~>t{X|(QP' );
define( 'LOGGED_IN_KEY',    '74;u0Yzw aj-NCFnUZsFv[,~]]~11LE/Yd~1vlu`?R6t2iC(OZ@8iH}r4zAkl!:o' );
define( 'NONCE_KEY',        '|-3t$[/q9St78A5_eC,J-@Nr8_0^s+ J#2GC3QsQ5Zra|,CPI+M*/]E`{Ik9Qf>|' );
define( 'AUTH_SALT',        'nuVt:g.})&P.YBX;^9Q$c`6=H(GwAGU&Q`ka/E>f-F(sKmS04D}2$u!drLR-q2T;' );
define( 'SECURE_AUTH_SALT', 'l)F}3vZfv<8kiI!EhX19{$doN:IA</<g::BcDx7ov(0f)%5HP^Ss1:YaO%V8Myh-' );
define( 'LOGGED_IN_SALT',   'a<)|]W{,%5OjcS#^i8KRkHN4tM23h3,`baD2-D:tAWHWjiIrJhCEo+D7<|$Z+;1R' );
define( 'NONCE_SALT',       'gbvu^dpGVXBch&G#d}l%5]lr=Il|G0d63*v5_b[R b(M]4]$<f$/jK~OX_bXm&j!' );

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
