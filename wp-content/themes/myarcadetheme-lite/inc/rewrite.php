<?php
/**
 * MyArcadeTheme Redirect / Rewrite Rules
 *
 * @package WordPress
 * @subpackage MyArcadeTheme
 */

if ( ! function_exists( 'myarcadetheme_blogcat_template' ) ) :
 /**
  * Redirect to blog category page
  *
  * @version 1.0.0
  * @since   1.0.0
  * @param   string $template Template file
  * @return  string
  */
  function myarcadetheme_blogcat_template( $template ) {

    if ( ! myarcadetheme_get_option( 'blogcat' ) ) {
      return $template;
    }

    if ( in_category( myarcadetheme_get_option( 'blogcat' ) ) ) {
      // Overwrite the template file if exist
      if ( file_exists( get_template_directory() . '/template-blog.php' ) ) {
        $template = get_template_directory() . '/template-blog.php';
      }
    }

    return $template;
  }
endif;
add_filter( 'category_template', 'myarcadetheme_blogcat_template' );

if ( ! function_exists('myarcadetheme_blog_template') ) :
  /**
   * Redirect to single blog view
   *
   * @version 1.0.0
   * @since   1.0.0
   * @param   string $template Template file
   * @return  string
   */
  function myarcadetheme_blog_template( $template ) {

    if ( ! myarcadetheme_get_option( 'blogcat' ) ) {
      return $template;
    }

    $post_cat = get_the_category();

    if ( is_singular() && !empty($post_cat) && ( in_category( myarcadetheme_get_option( 'blogcat' ) ) || ( myarcadetheme_get_option( 'blogcat' ) == $post_cat[0]->category_parent ) ) ) {
      // Overwrite the template file if exist
      if ( file_exists( get_template_directory() . '/template-blog-post.php' ) ) {
        $template = get_template_directory() . '/template-blog-post.php';
      }
    }

    return $template;
  }
endif;
add_filter('single_template', 'myarcadetheme_blog_template');

if ( ! function_exists( 'myarcadetheme_adjust_permalinks' ) ) :
  /**
   * Add rewrite rules on theme switching and flush rewrite rules
   *
   * @version 5.13.0
   * @access  public
   * @param   [type]  $oldname  [description]
   * @param   boolean $oldtheme [description]
   * @return  [type]            [description]
   */
  function myarcadetheme_adjust_permalinks( $oldname, $oldtheme = false ) {
  }
endif;
add_action('after_switch_theme', 'myarcadetheme_adjust_permalinks', 0);

if ( ! function_exists( 'myarcadetheme_add_rules' ) ) :
  /**
   * Add required rewrite rules
   *
   * @version 1.0.0
   * @since   1.0.0
   * @return  void
   */
  function myarcadetheme_add_rules() {
  }
endif;
add_action( 'init', 'myarcadetheme_add_rules', 0 );

if ( ! function_exists( 'myarcadetheme_play_template_redirect' ) ) :
  /**
   * Handles game display when user comes from the pre-game page (game landing page)
   *
   * @version 1.0.0
   * @since   1.0.0
   * @return void
   */
  function myarcadetheme_play_template_redirect() {
    global $wp_query;

    $endpoint = myarcadetheme_get_option( 'game_play_permalink_endpoint', 'play' );

    if ( empty( $endpoint ) ) return;

    // if this is not a request for game play then bail
    if ( !is_singular() || !isset($wp_query->query_vars[$endpoint]) ) {
      return;
    }

    // Include game play template
    get_template_part( "single", "play" );
    exit;
  }
endif;

if ( ! function_exists( 'myarcadetheme_fullscreen_teplate_redirect' ) ) :
  /**
   * Handles full screen redirect
   *
   * @version 1.0.0
   * @since   1.0.0
   * @return  void
   */
  function myarcadetheme_fullscreen_teplate_redirect() {
  }
endif;