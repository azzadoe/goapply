<?php
function myarcadetheme_init_actions() {
  /** Add WPSeoContentManager Compatibility **/
  if ( function_exists('get_WPSEOContent') ) {
    add_action('myarcadetheme_after_404_content', 'get_WPSEOContent');
    add_action('myarcadetheme_after_archive_content', 'get_WPSEOContent');
    add_action('myarcadetheme_after_index_content', 'get_WPSEOContent');
  }
}
add_action( 'init', 'myarcadetheme_init_actions' );

function myarcadetheme_action_after_404_content() {
  do_action('myarcadetheme_after_404_content');
}

function myarcadetheme_action_after_archive_content() {
  do_action('myarcadetheme_after_archive_content');
}

function myarcadetheme_action_after_index_content() {
  do_action('myarcadetheme_after_index_content');
}

function myarcadetheme_before_boxes() {

  $option = myarcadetheme_get_option( 'box_design' );

  if( $option == 'half') {
    echo '<ul class="cntcls-n6">';
  }
  elseif( $option == 'vertical' ) {
    echo'<!--<vertical>--><ul class="cntcls-n4">';
  }
}
add_action( 'myarcadetheme_before_boxes', 'myarcadetheme_before_boxes' );

/**
 * [myarcadetheme_after_boxes description]
 *
 * @version 1.0.0
 * @since   1.0.0
 * @access  public
 * @return  [type] [description]
 */
function myarcadetheme_after_boxes() {

  $option = myarcadetheme_get_option( 'box_design' );

  if( $option == 'half' ) {
   echo '</ul>';
  }
  elseif( $option == 'vertical' ) {
    echo'</ul><!--</vertical>-->';
  }
}
add_action( 'myarcadetheme_after_boxes', 'myarcadetheme_after_boxes' );

/**
 * Display an alert message if there is an active contest for this game
 * and if the user doesn't participate in the contest.
 *
 * @version 1.0.0
 * @since   1.0.0
 * @access  public
 * @return  void
 */
function myarcadetheme_contest_alert() {

  // Check if MyArcadeContest is installed
  if ( ! function_exists( 'myarcadecontest_get_contest_id_for_this_game' ) || ! function_exists( 'myarcadecontest_check_user_is_in_contest' ) ) {
    return;
  }

  $contest_id = myarcadecontest_get_contest_id_for_this_game();
  $user_id    = get_current_user_id();

  // Check if user has already joined this contest
  if ( ! $contest_id || myarcadecontest_check_user_is_in_contest( $contest_id, $user_id ) ) {
    return;
  }

  ob_start();
  ?>
  <div id="message" class="info">
    <p>
      <strong><?php _e('Howdy!', 'myarcadetheme' ); ?></strong> <?php printf( __('There is an active contest available for this game. Click %shere%s to join the contest!', 'myarcadetheme' ), '<a href="'.get_permalink( $contest_id ).'" title="'.the_title_attribute( array( 'echo' => false, 'post' => $contest_id ) ).'">' , '</a>' ); ?>
    </p>
  </div>
  <?php
  ob_end_flush();
}
add_action('myarcadetheme_before_game', 'myarcadetheme_contest_alert' );

/**
 * Replace the default WordPress logo with a custom logo
 *
 * @version 2.0.0
 * @since   2.0.0
 * @return  void
 */
function myarcadetheme_login_logo() {
  $login_logo = myarcadetheme_get_option( 'logologin' );
  if ( empty( $login_logo['url'] ) ) {
    $login_logo = myarcadetheme_get_option( 'logohd' );
    if ( empty( $login_logo['url'] ) ) {
      $login_logo['url'] = get_template_directory_uri() .' /images/my-arcade-theme.png';
    }
  }
  ?>
  <style type="text/css">
    .login h1 a {
      background-image: url('<?php echo $login_logo['url']; ?>') !important;
      background-size: auto auto !important; width: auto !important;
    }
  </style>
  <?php
}
add_action( 'login_enqueue_scripts', 'myarcadetheme_login_logo' );

/**
 * Change the login logo URL to our site
 *
 * @version 2.0.0
 * @since   2.0.0
 * @access  public
 * @return  string Home URL
 */
function myarcadetheme_login_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'myarcadetheme_login_logo_url' );

/**
 * Change login logo title from 'Powered by WordPress' to our site name
 *
 * @version 2.0.0
 * @since   2.0.0
 * @access  public
 * @return  string Site name
 */
function myarcadetheme_login_logo_title() {
  return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'myarcadetheme_login_logo_title' );

/**
 * Adjust the game width in fullscreen view for desktops
 *
 * @version 5.1.0
 * @since   5.1.0
 * @param   string $width Width in %
 * @return  string
 */
function myarcadetheme_fullscreen_width( $width ) {
  return '97%';
}

/**
 * Adjust the game height in fullscreen view for desktops
 *
 * @version 5.1.0
 * @since   5.1.0
 * @param   string $height Height in %
 * @return  string
 */
function myarcadetheme_fullscreen_height( $height ) {
  return '97%';
}

function myarcadetheme_before_game() {

  if ( '2' == myarcadetheme_get_option('game_buttons', 1) ) {
    get_template_part( "partials/game", "buttons" );
  }
}
add_action( 'myarcadetheme_before_game', 'myarcadetheme_before_game' );

function myarcadetheme_after_game() {

  if ( '1' == myarcadetheme_get_option('game_buttons', 1) ) {
    get_template_part( "partials/game", "buttons" );
  }

}
add_action( 'myarcadetheme_after_game', 'myarcadetheme_after_game' );
