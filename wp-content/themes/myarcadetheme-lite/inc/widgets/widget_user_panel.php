<?php
/*
 * Shows the User Login panel. When the user is logged in serveral user links
 * are shown.
 */

class WP_Widget_MABP_User_Login extends WP_Widget {

  // Constructor
  function __construct() {
    $widget_ops   = array('description' => __('Shows the user login and the user panel.', 'myarcadetheme'));
    parent::__construct('MABP_User_Login', __('MyArcade User Login Panel', 'myarcadetheme'), $widget_ops);
    add_action('wp_print_scripts', array($this, 'js_load_scripts'));
  }

  function js_load_scripts () {
    if ( defined('WDFB_PLUGIN_URL')) {
      if (!is_admin()) wp_enqueue_script('wdfb_connect_widget', WDFB_PLUGIN_URL . '/js/wdfb_connect_widget.js');
    }
  }

  // Display Widget
  function widget($args, $instance) {

    extract($args);

    $title = empty( $instance['title'] ) ? '' : esc_attr( $instance['title'] );

    if ( empty( $instance['loginform'] ) ) {
      $instance['loginform'] = 'show';
    }

    if ( empty( $instance['favoritegames'] ) ) {
      $instance['favoritegames'] = 'show';
    }

    // Get current user
    $current_user = wp_get_current_user();

    // Don't show anything if login form is disabled and if the user isn't logged in
    if ( ! $current_user->ID && 'hide' == $instance['loginform']  ) {
      return;
    }

    echo $before_widget.$before_title.$title.$after_title;

    // <-- START --> HERE COMES THE OUPUT
    if ( $current_user->ID ) {
      // user is logged in
      global $mngl_options, $mngl_message;
      ?>
      <ul class="leabrd">
        <li>
          <figure><?php echo get_avatar( $current_user->ID, $size = '85'); ?></figure>
          <p><?php _e('Hello', 'myarcadetheme'); ?>, <strong><?php echo $current_user->display_name; ?></strong>!</p>
          <ul class="menusr">
            <li class="mycnt">
              <a class="botn" href="<?php if(defined('BP_VERSION')){ global $bp; echo $bp->loggedin_user->domain; }else{ echo home_url().'/wp-admin/profile.php'; } ?>" title="<?php _e('MY ACCOUNT', 'myarcadetheme'); ?>"><?php _e('MY ACCOUNT', 'myarcadetheme'); ?></a>
              <ul>
                <?php if ( defined('BP_VERSION') ) : ?>
                  <?php global $bp; ?>
                  <?php if( bp_is_active('activity') ) : ?>
                    <li><a href="<?php echo $bp->loggedin_user->domain . bp_get_activity_slug() . '/'; ?>"><?php _e('Activity', 'myarcadetheme'); ?></a></li>
                  <?php endif; ?>
                  <li><a href="<?php echo site_url( bp_get_members_root_slug() ); ?>"><?php _e('Members', 'myarcadetheme'); ?></a></li>
                  <?php if( bp_is_active('groups') ) : ?>
                    <li><a href="<?php echo $bp->loggedin_user->domain . bp_get_groups_slug() . '/'; ?>"><?php _e('Groups', 'myarcadetheme'); ?></a></li>
                  <?php endif; ?>
                  <?php if ( bp_is_active( 'friends' ) ) : ?>
                    <li><a href="<?php echo $bp->loggedin_user->domain . bp_get_friends_slug() . '/'; ?>"><?php _e('Friends', 'myarcadetheme'); ?></a></li>
                  <?php endif; ?>
                  <li><a href="<?php echo $bp->loggedin_user->domain ?>"><?php _e('Profile', 'myarcadetheme'); ?></a></li>
                  <?php if ( isset($bp->myscore) ) : ?>
                    <li><a href="<?php echo $bp->loggedin_user->domain . $bp->myscore->slug . '/'; ?>"><?php _e('My Scores', 'myarcadetheme'); ?></a></li>
                  <?php endif; ?>
                <?php else: ?>
                  <li><a href="<?php echo home_url(); ?>/wp-admin/index.php"><?php _e('Go to Dashboard', 'myarcadetheme'); ?></a></li>
                  <li><a href="<?php echo home_url(); ?>/wp-admin/profile.php"><?php _e('Edit My Profile', 'myarcadetheme'); ?></a></li>
                <?php endif; ?>
              </ul>
            </li>
            <li><a class="botn logout" href="<?php echo wp_logout_url( home_url() ); ?>" title="<?php _e('LOGOUT', 'myarcadetheme'); ?>"><?php _e('LOGOUT', 'myarcadetheme'); ?></a></li>
          </ul>
        </li>
      </ul>
      <?php if ( function_exists('wpfp_list_favorite_posts') && 'show' == $instance['favoritegames'] ) : ?>
        <h4><?php _e('Your Favorite Games', 'myarcadetheme'); ?></h4>
        <?php wpfp_list_favorite_posts(); ?>
      <?php endif;
    }
    else {
      // user isn't logged in
      ?>
      <div class="blk-cn bbp_widget_login clear">
        <?php if ( $instance['loginform'] == 'show' ) : ?>
          <form action="<?php echo wp_login_url(); ?>" method="post">
            <fieldset id="loginBox">
              <label><input autocomplete="off" type="text" name="log" id="log" placeholder="<?php _e('username', 'myarcadetheme'); ?>"></label>
              <label><input autocomplete="off" type="password" name="pwd" id="pwd" placeholder="<?php _e('password', 'myarcadetheme'); ?>"></label>
              <input type="hidden" name="redirect_to" value="<?php echo myarcadetheme_get_current_url(); ?>/">
              <input type="submit" name="Login" value="<?php _e('Login', 'myarcadetheme'); ?>" class="botn-login">
              <?php if ( function_exists( 'new_fb_sign_button' ) ) : ?>
                <a class="botn-flgn fa-facebook" href="<?php echo wp_login_url(); ?>?loginFacebook=1" onclick="window.location = '<?php echo wp_login_url(); ?>?loginFacebook=1; return false;"><?php _e('LOGIN WITH', 'myarcadetheme'); ?></a>
              <?php endif; ?>
            </fieldset>
          </form>
          <?php if ( get_option('users_can_register') ) : ?>
            <p><a href="<?php echo wp_registration_url(); ?>"><?php _e('Register', 'myarcadetheme'); ?></a></p>
          <?php endif; ?>
          <p><a href="<?php echo wp_lostpassword_url(); ?>"><?php _e('Lost password?', 'myarcadetheme'); ?></a></p>
        <?php elseif ( $instance['loginform'] == 'button' ) : ?>
          <a class="botn-login <?php if ( ! get_option('users_can_register') ) echo 'botn-flgn-100'; ?> fa-user" href="<?php echo wp_login_url(); ?>"><?php _e('Login', 'myarcadetheme'); ?></a>
          <?php if ( get_option('users_can_register') ) : ?>
          <a class="botn-login fa-pencil" href="<?php echo wp_registration_url(); ?>"><?php _e('Register', 'myarcadetheme'); ?></a>
          <?php endif; ?>
          <?php if ( function_exists( 'new_fb_sign_button' ) ) : ?>
            <p><a class="botn-flgn botn-flgn-100 fa-facebook" href="<?php echo wp_login_url(); ?>?loginFacebook=1" onclick="window.location = '<?php echo wp_login_url(); ?>?loginFacebook=1; return false;"><?php _e('LOGIN WITH', 'myarcadetheme'); ?></a></p>
          <?php endif; ?>
        <?php endif; ?>
      </div>
      <?php
    }
    // <-- END --> HERE COMES THE OUPUT

    echo $after_widget;
  }

  // Update Widget
  function update($new_instance, $old_instance) {

    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['loginform'] = $new_instance['loginform'];
    $instance['favoritegames'] = $new_instance['favoritegames'];

    return $instance;
  }

  // Display Widget Control Form
  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array(
      'title' => __('User Panel', 'myarcadetheme'),
      'loginform' => 'show',
      'favoritegames' => 'show' ) );

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );

    myarcadetheme_form_select( array(
      'field_title' => __("Login Form", 'myarcadetheme'),
      'field_id' => $this->get_field_id('loginform'),
      'field_name' => $this->get_field_name('loginform'),
      'options' => array(
        'show'    => __("Show", 'myarcadetheme' ),
        'button'  => __("Button", 'myarcadetheme' ),
        'hide'    => __("Hide", 'myarcadetheme' ),
      ),
      'selection' => $instance['loginform'],
    ));

    myarcadetheme_form_select( array(
      'field_title' => __("Favorite Games", 'myarcadetheme'),
      'field_id' => $this->get_field_id('favoritegames'),
      'field_name' => $this->get_field_name('favoritegames'),
      'options' => array(
        'show'    => __("Show", 'myarcadetheme' ),
        'hide'    => __("Hide", 'myarcadetheme' ),
      ),
      'selection' => $instance['favoritegames'],
    ));
  }
}

/**
 * Register the widget
 */
function myarcadetheme_widget_user_login() {
  register_widget('WP_Widget_MABP_User_Login');
}
add_action( 'widgets_init', 'myarcadetheme_widget_user_login' );
