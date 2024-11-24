<?php
/**
 * MyArcadeTheme Ajax Handlers
 *
 * @package WordPress
 * @subpackage MyArcadeTheme
 */

/**
 * Handle Ajax requests
 *
 * @version 1.0.0
 * @since   1.0.0
 * @access  public
 * @return  void
 */
function myarcadetheme_ajax_action() {

  $nonce = filter_input( INPUT_POST, 'nonce' );

  if ( ! wp_verify_nonce( $nonce, 'myarcadetheme-promotedgames-nonce' ) ) {
    die ();
  }

  if ( 'myarcadetheme_ajax_action' == filter_input( INPUT_POST, 'action' ) ) {
    $type = filter_input( INPUT_POST, 'type' );

    // Decide what to do
    switch ( $type ) {
      case 'register': {
        // New user registration
        $username = sanitize_user( filter_input( INPUT_POST, 'username' ) );
        $email = sanitize_email( filter_input( INPUT_POST, 'email' ) );
        $error=''; $errora=''; $errorb=''; $errorc='';
        //$_POST['passb']='';
        $invalid_usernames = array( 'admin' );

        if ( empty($username) || !validate_username( $username ) || in_array( $username, $invalid_usernames ) || username_exists( $username ) or strlen($username) < 5) {
          $errora=1;
          $error=1;
        }
        else {
          $errora=0;
        }

        if ( !is_email( $email ) || empty( $email ) || email_exists( $email ) ) {
          $errorb=1;
          $error=1;
        }
        else {
          $errorb=0;
        }

        $password = filter_input( INPUT_POST, 'pass' );
        $passwordb = filter_input( INPUT_POST, 'passb' );

        if ( empty( $password ) or strlen( $password ) < 6 and $password != $passwordb ) {
          $errorc=1;
          $error=1;
        }
        else {
          $errorc=0;
        }

        if ( empty( $error ) ) {
          global $wpdb;
          $user_id = wp_insert_user( array ('user_email' => esc_sql( $wpdb->esc_like($email) ), 'user_pass' => esc_sql( $wpdb->esc_like( $password ) ),'user_login' => esc_sql( $wpdb->esc_like($username)),'display_name' => esc_sql( $wpdb->esc_like($username)) ) ) ;
            echo '<div class="ok"><p>'.sprintf( __('Registration successfully completed. You can now log in %shere%s.', 'myarcadetheme'), '<a data-dismiss="modal" id="lgtclosemt" href="#" data-toggle="modal" data-tooltip="tooltip" data-placement="top" data-target="#modl-logi" title="" data-original-title="', '">', '</a>').'</p></div>';
            wp_new_user_notification( $user_id );
        }
        else {
          echo $errora.'|'.$errorb.'|'.$errorc;
        }
      } break;

      case 'login': {
        // Log in
        global $wpdb;

        $username = filter_input( INPUT_POST, 'log' );
        $password = filter_input( INPUT_POST, 'pwd' );

        $auth = wp_authenticate( $username, $password);

        if ( is_wp_error( $auth ) ) {
          echo 1;
        }
        else{
          echo 0;
        }
      } break;

      default: {
        // Sort
        $promoted_order = filter_input( INPUT_POST, 'value', FILTER_VALIDATE_INT );
        if ( ! $promoted_order ) {
          $promoted_order = 1;
        }

        // Set cookie for one day 60*60*24
        setcookie( 'promoted_order', intval( $promoted_order ), time()+60*60*24, COOKIEPATH, COOKIE_DOMAIN, false );

        set_query_var( 'order', $promoted_order );
        include( locate_template( "partials/index-promoted-loop.php" ) );
      } break;
    }
  }

  wp_die();
}
add_action( 'wp_ajax_myarcadetheme_ajax_action', 'myarcadetheme_ajax_action' );
add_action( 'wp_ajax_nopriv_myarcadetheme_ajax_action', 'myarcadetheme_ajax_action');

/**
 * Store design selection in a cookie
 *
 * @version 5.2.1
 * @since   1.0.0
 * @return  void
 */
function myarcadetheme_cat_ajax() {

  $nonce = filter_input( INPUT_POST, 'nonce' );
  $action = filter_input( INPUT_POST, 'action' );
  $type = filter_input( INPUT_POST, 'type' );

  $design = filter_input( INPUT_POST, 'design', FILTER_VALIDATE_INT, array( "options" => array( "default" => myarcadetheme_get_option('archive_design', 3 ) ) ) );
  $order = filter_input( INPUT_POST, 'order', FILTER_VALIDATE_INT, array("options" => array( "default" => myarcadetheme_get_option('archive_order', 1 ) ) ) );

  if ( ! wp_verify_nonce( $nonce, 'mt-nonce' ) ) {
    wp_die();
  }

  if( 'mt_cat_action' == $action ) {
    if( 1 == $type ){
      setcookie('designcat', $design , time()+3600*24, COOKIEPATH, COOKIE_DOMAIN, false);
    }else{
      setcookie('ordercat', $order, time()+3600*24, COOKIEPATH, COOKIE_DOMAIN, false);
    }
  }
  exit;
}
add_action( 'wp_ajax_mt_cat_action', 'myarcadetheme_cat_ajax' );
add_action( 'wp_ajax_nopriv_mt_cat_action', 'myarcadetheme_cat_ajax');