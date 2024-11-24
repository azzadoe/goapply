<?php
/**
 * MyArcadeTheme Setup
 *
 * @package WordPress
 * @subpackage MyArcadeTheme
 */

// Include backend stuff only on admin
if ( is_admin() ) {
  // Include widget form functions
  get_template_part( 'inc/admin/widget-form-functions' );

  // Include option framework
  get_template_part( 'inc/admin/config' );

  // Include TGM Plugin Activation
  get_template_part( 'inc/admin/plugins' );

  // Theme update
  get_template_part( 'inc/admin/theme-update' );
}

/**
 * Retrieve a theme option
 *
 * @version 1.0.0
 * @since   1.0.0
 * @param   string $option_name
 * @return  mixed
 */
function myarcadetheme_get_option( $option_name, $default = false ) {
  global $myarcadetheme;

  // Some Lite modifications
  switch( $option_name ) {
    case 'box_design': {
      return 'full';
    } break;

    case 'pregame' :
    case 'fullscreen':
    case 'mobile':
    case 'game_preloader_ads': {
      return 0;
    } break;

    case 'colorscheme':
    case 'game_layout': {
      return 1;
    } break;
  }

  if ( empty( $myarcadetheme ) ) {
    $myarcadetheme = get_option( 'myarcadetheme' );
  }

  /** Original Code **/
  if ( ! isset( $myarcadetheme[ $option_name ] ) ) {
    return $default;
  }

  return $myarcadetheme[ $option_name ];

  /** MyArcadeTheme.com Code **/
  /*if ( isset( $myarcadetheme[ $option_name ] ) ) {
    $value = $myarcadetheme[ $option_name ];
  }
  else {
    $value = $default;
  }

  return apply_filters( 'myarcadetheme_get_option',  $value, $option_name );
  */
}

/**
 * Set the content width based on the theme's design and stylesheet
 */
if ( ! isset( $content_width ) ) {
  $content_width = 1200;
}

if ( ! function_exists( 'myarcadetheme_activation' ) ) :
/**
 * Set up theme defaults on theme activation
 *
 * @version 1.0.0
 * @since   1.0.0
 * @return  void
 */
function myarcadetheme_activation( $oldname, $oldtheme=false ) {
  // Update MyGameListCreator setting
  if ( function_exists('create_mygame_list') ) {
    $options = get_option( 'mygamelistcreator' );

    $updated_options = array(
      'list_limit'           => 100,
      'list_title'           => '<div class="titl">'.__( "LATEST GAMES", "myarcadetheme" ).'</div>',
      'list_begin_wrap'      => '<div id="gamelist" class="blk-cn">',
      'list_end_wrap'        => '</div>',
      'list_item_begin_wrap' => '<li>',
      'list_item_end_wrap'   => '</li>',
      'list_char_limit'      => 22,
      'list_include_cats'    => '',
      'list_list_begin_wrap' => '<ul>',
      'list_list_end_wrap'   => '</ul>',
      'list_template'        => '<p>'."\n".'<strong>%TITLE_WITH_LINK%</strong><br />'."\n".'<div style="float:left;">%THUMBNAIL_WITH_LINK%</div> %DESCRIPTION%'."\n".'</p>'."\n".'<p style="clear:left;"></p><br />',
      'list_leading'         => 'No',
      'autocreate_list'      => 'Yes',
      'autocreate_list_page' => 'No',
      'list_rows'            => 4,
    );

    update_option('mygamelistcreator', $updated_options);
    create_mygame_list();
  }
}
endif;
add_action( "after_switch_theme", "myarcadetheme_activation" );

if ( ! function_exists( 'myarcadetheme_setup') ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @version 4.1.0
 * @since   1.0.0
 * @return  void
 */
function myarcadetheme_setup() {

  // Make theme available for translation.
  // Translations can be filed in the /languages/ directory.
  load_theme_textdomain( 'myarcadetheme', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  // Let WordPress manage the document title.
  // By adding theme support, we declare that this theme does not use a
  // hard-coded <title> tag in the document head, and expect WordPress to
  // provide it for us.
  add_theme_support( 'title-tag' );

  // Enable support for Post Thumbnails on posts and pages.
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 127, 127, true );
  //add_image_size( 'contest-promo', 127, 127 );

  // Enable custom background images
  add_theme_support( 'custom-background' );

  // This theme uses wp_nav_menu() in one location
  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'myarcadetheme' ),
    'top' => __('Top Bar Menu', 'myarcadetheme' ),
  ) );

  // Switch default core markup for search form, comment form, and comments
  // to output valid HTML5.
  add_theme_support( 'html5', array(
    'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
  ) );

  // We don't want to show our WordPress version
  remove_action('wp_head', 'wp_generator');

  // Don't show the admin bar
  if ( ! myarcadetheme_get_option( 'admin_bar', 0 ) ) {
    add_filter( 'show_admin_bar', '__return_false' );
  }

  // Add shortcode support to text widget
  add_filter( 'widget_text', 'do_shortcode' );

  // Declare WooCommerce support
  add_theme_support( 'woocommerce' );
}
endif;
add_action( "after_setup_theme", "myarcadetheme_setup" );

/**
 * Enables MCE Editor For bbPress
 *
 * @version 3.1.0
 * @since   3.1.0
 * @param   array $args
 * @return  array
 */
function myarcadetheme_bbp_enable_visual_editor( $args = array() ) {
  $args['tinymce'] = true;
  $args['quicktags'] = false;
  return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'myarcadetheme_bbp_enable_visual_editor' );

/**
 * Adds Fields To User Profiles For Author Box
 *
 * @version 5.3.0
 * @since   5.3.0
 * @return  void
 */
if ( ! function_exists( 'myarcadetheme_custom_profile_methods' ) ) {
		function myarcadetheme_custom_profile_methods( $profile_fields ) {
			$profile_fields['facebook'] = esc_html__( 'Facebook URL', 'myarcadetheme' );
			$profile_fields['twitter'] = esc_html__( 'Twitter URL', 'myarcadetheme' );
			$profile_fields['googleplus'] = esc_html__( 'Google+ URL', 'myarcadetheme' );
			$profile_fields['pinterest'] = esc_html__( 'Pinterest URL', 'myarcadetheme' );
			$profile_fields['youtube'] = esc_html__( 'YouTube URL', 'myarcadetheme' );
			$profile_fields['vimeo'] = esc_html__( 'Vimeo URL', 'myarcadetheme' );
			$profile_fields['flickr'] = esc_html__( 'Flickr URL', 'myarcadetheme' );
			$profile_fields['linkedin'] = esc_html__( 'LinkedIn URL', 'myarcadetheme' );
			$profile_fields['instagram'] = esc_html__( 'Instagram URL', 'myarcadetheme' );
			return $profile_fields;
		}
	}
add_filter( 'user_contactmethods', 'myarcadetheme_custom_profile_methods' );