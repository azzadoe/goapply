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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'gooapply_db' );

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
define( 'AUTH_KEY',         'cx)!K@kHw$=YC+RUcq!eRs%k{-_)XkdRe`V3JV|`jB ;iNm[(|.q2Jg-ZfeXE!B3' );
define( 'SECURE_AUTH_KEY',  'j;rTa2~HMd=NFS:Y+F%9&4fB&?T[w}+R5]:b5EdvYP/Wzi*Pnt%ROJ3*gmEw@ua#' );
define( 'LOGGED_IN_KEY',    '!v}F7^^CuJ/c<}dOR;|2= Ia_(#8aX20P*p}v8@bp*sZ)i,S]a#Yh-!zlaCzMD]x' );
define( 'NONCE_KEY',        'CU>E*$n9(n$=2Jn-MigIk]n@9T/E51*?qygqw5u{ X%^IQBnX;HQFw(XVZ#A@JBM' );
define( 'AUTH_SALT',        '?ySCl9<PncIQ4[<qNBuCsFrON&muIYz&XkB+voZKa={ZJB!L|mwa9mYhj@q$<O1r' );
define( 'SECURE_AUTH_SALT', '5+B>IE@gJ3cj!IV`(*-+]98z8dm:9As(~m407{51I|GW)q5 jx=^fWlX&E3U^RjB' );
define( 'LOGGED_IN_SALT',   'X4b9c!A+a*mIK:REHpm<lu+=@:e<ifR!v#{iuDe0e)*$_4s`.VA!g%i:0}sXjWna' );
define( 'NONCE_SALT',       '8U3@<;kF`FM#xe7+aTCUq@o<+&K5!wBf2]Y:0A6$0Uy/U;6@4>yh)Ba1(]D)p8I$' );

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
