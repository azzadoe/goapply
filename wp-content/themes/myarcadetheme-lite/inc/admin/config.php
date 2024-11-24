<?php
/**
 * Options Config file
 * @uses ReduxFramework
 */

/**
 * Checks if redux is installed and deletes tgmpa notice dismissed if framework is missing
 *
 * @version 4.1.0
 * @since   4.1.0
 * @return  void
 */
function myarcade_redux_check() {
  if ( ! class_exists( 'Redux' ) ) {
    delete_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_myarcadetheme' );
  }
}
add_action( 'init', 'myarcade_redux_check' );

if ( class_exists( 'Redux' ) ) :

  function myarcadetheme_redux_version() {
    if ( class_exists('Redux_Core')) {
      return Redux_Core::$version;
    }
    else {
      return 3.0;
    }
  }

function myarcadetheme_redux_set_args( $opt_name, $args ) {
  if ( version_compare( myarcadetheme_redux_version(), '3.5.0', '>' ) ) {
    Redux::set_args( $opt_name, $args );
  }
  else {
    Redux::setArgs( $opt_name, $args );
  }
}

function myarcadetheme_redux_set_section( $opt_name = '', $section = array() ) {
  if ( version_compare( myarcadetheme_redux_version(), '3.5.0', '>' ) ) {
    Redux::set_section( $opt_name, $section );
  }
  else {
    Redux::setSection( $opt_name, $section );
  }
}

/** remove redux menu under the tools **/
function myarcadetheme_remove_redux_menu() {
  remove_submenu_page( 'tools.php', 'redux-framework' );
}
add_action( 'admin_menu', 'myarcadetheme_remove_redux_menu', 12 );

function myarcadetheme_custom_redux_style() {
  wp_register_style(
    'myarcadetheme_redux_style',
    get_template_directory_uri() . '/css/admin/redux.css',
    array( 'redux-admin-css' )
  );
  wp_enqueue_style('myarcadetheme_redux_style');
}
add_action( 'redux/page/myarcadetheme/enqueue', 'myarcadetheme_custom_redux_style' );

// Deactivate News Flash
$GLOBALS['redux_notice_check'] = 1;

// This is your option name where all the Redux data is stored.
$opt_name = "myarcadetheme";

// Get theme settings
$theme = wp_get_theme();

$args = array(
  // TYPICAL -> Change these values as you need/desire
  'opt_name'             => $opt_name,
  // This is where your data is stored in the database and also becomes your global variable name.
  'display_name'         => $theme->get( 'Name' ),
  // Name that appears at the top of your panel
  'display_version'      => $theme->get( 'Version' ),
  // Version that appears at the top of your panel
  'menu_type'            => 'submenu',
  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
  'allow_sub_menu'       => true,
  // Show the sections below the admin menu item or not
  'menu_title'           => __( 'Theme Options', 'myarcadetheme' ),
  'page_title'           => __( 'Theme Options', 'myarcadetheme' ),
  // You will need to generate a Google API key to use this feature.
  // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
  'google_api_key'       => '',
  // Set it you want google fonts to update weekly. A google_api_key value is required.
  'google_update_weekly' => false,
  // Must be defined to add google fonts to the typography module
  'async_typography'     => true,
  // Use a asynchronous font on the front end or font string
  //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
  'admin_bar'            => true,
  // Show the panel pages on the admin bar
  'admin_bar_icon'       => 'dashicons-portfolio',
  // Choose an icon for the admin bar menu
  'admin_bar_priority'   => 50,
  // Choose an priority for the admin bar menu
  'global_variable'      => '',
  // Set a different name for your global variable other than the opt_name
  'dev_mode'             => false,
  /*'forced_dev_mode_off'  => true,*/
  'ajax_save'            => true,
  'allow_tracking'       => false,
  'tour'                 => false,
  // Show the time the page took to load, etc
  'update_notice'        => true,
  // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
  'customizer'           => false,
  // Enable basic customizer support
  //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
  //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

  // OPTIONAL -> Give you extra features
  'page_priority'        => null,
  // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
  'page_parent'          => 'themes.php',
  // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
  'page_permissions'     => 'manage_options',
  // Permissions needed to access the options panel.
  'menu_icon'            => '',
  // Specify a custom URL to an icon
  'last_tab'             => '',
  // Force your panel to always open to a specific tab (by id)
  'page_icon'            => 'icon-themes',
  // Icon displayed in the admin panel next to your menu_title
  'page_slug'            => 'myarcadetheme_options',
  // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
  'save_defaults'        => true,
  // On load save the defaults to DB before user clicks save or not
  'default_show'         => false,
  // If true, shows the default value next to each field that is not the default value.
  'default_mark'         => '',
  // What to print by the field's title if the value shown is default. Suggested: *
  'show_import_export'   => true,
  // Shows the Import/Export panel when not used as a field.

  // CAREFUL -> These options are for advanced use only
  'transient_time'       => 60 * MINUTE_IN_SECONDS,
  'output'               => true,
  // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
  'output_tag'           => true,
  // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
  'footer_credit'     => __( 'MyArcadeTheme by <a href="https://myarcadeplugin.com/" title="WordPress Arcade" rel="noopener" itemprop="url">MyArcadePlugin</a>', 'myarcadetheme' ),

  // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
  'database'             => '',
  // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
  'use_cdn'              => true,
  // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

  // HINTS
  'hints'                => array(
      'icon'          => 'el el-question-sign',
      'icon_position' => 'right',
      'icon_color'    => 'lightgray',
      'icon_size'     => 'normal',
      'tip_style'     => array(
          'color'   => 'red',
          'shadow'  => true,
          'rounded' => false,
          'style'   => 'bootstrap',
      ),
      'tip_position'  => array(
          'my' => 'top left',
          'at' => 'bottom right',
      ),
      'tip_effect'    => array(
          'show' => array(
              'effect'   => 'fade',
              'duration' => '100',
              'event'    => 'click mouseover',
          ),
          'hide' => array(
              'effect'   => 'slide',
              'duration' => '500',
              'event'    => 'click mouseleave',
          ),
      ),
  )
);

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
$args['share_icons'][] = array(
  'url'   => 'https://facebook.com/MyArcadePlugin',
  'title' => __('Like us on Facebook', 'myarcadetheme'),
  'icon'  => 'el-icon-facebook'
);

$args['share_icons'][] = array(
  'url'   => 'https://twitter.com/MyArcadePlugin',
  'title' => __('Follow us on Twitter', 'myarcadetheme'),
  'icon'  => 'el-icon-twitter'
);

$args['share_icons'][] = array(
  'url'   => 'https://www.youtube.com/user/NetReviewDE/videos',
  'title' => __('Visit us on YouTube', 'myarcadetheme'),
  'icon'  => 'el-icon-youtube'
);

// Set Arguments
myarcadetheme_redux_set_args( $opt_name, $args );

// Set Sections

// General Settings
myarcadetheme_redux_set_section( $opt_name, array(
  'title'     => __('General Settings', 'myarcadetheme'),
  'desc'      => __('This section customizes the global theme options.', 'myarcadetheme'),
  'icon'      => 'el-icon-cog',
  'fields'    => array(
    array(
      'id'    => 'sidebar_position',
      'type'  => 'image_select',
      'title' => __("Sidebar position", 'myarcadetheme'),
      'hint'  => array(
        'title' => __("Sidebar position", 'myarcadetheme'),
        'content' => __("Select the sidebar position.", 'myarcadetheme'),
      ),
      'options' => array(
        'left' => array(
          'alt' => __("Left", 'myarcadetheme'),
          'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
        ),
        'right' => array(
          'alt' => __("Left", 'myarcadetheme'),
          'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
        ),
      ),
      'default' => 'right',
    ),

    array(
      'id' => 'sticky_sidebar',
      'type' => 'switch',
      'title' => __('Sticky Sidebar', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Sticky Sidebar", 'myarcadetheme'),
        'content' => __("If enabled, this will cause the sidebar to scroll down to the end of screen (always keep your widgets in view of your visitors).", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'smooth_scroll',
      'type' => 'switch',
      'title' => __('Smooth Scrolling', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Smooth Scrolling", 'myarcadetheme'),
        'content' => __("If enabled, this will cause the scrollbar style to change and to slowly scroll down the page in a modern IPad feel.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'back_top',
      'type' => 'switch',
      'title' => __('Back To Top', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Back To Top", 'myarcadetheme'),
        'content' => __("If enabled, this will load a back to top button on the bottom right hand corner of the screen.", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'lazy_load',
      'type' => 'switch',
      'title' => __('Lazy Load', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Lazy Load", 'myarcadetheme'),
        'content' => __("If enabled, this option will delay loading of images. Images outside the viewport are not loaded until user scolls to them.", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'lazy_load_animation',
      'type' => 'switch',
      'title' => __('Lazy Load Animation', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Lazy Load Animation", 'myarcadetheme'),
        'content' => __("If enabled, an image loading animation will be displayed during the loading.", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id'        => 'character_set',
      'type'      => 'select',
      'title'     => __('Character Set', 'myarcadetheme'),
      'hint'      => array(
        'title' => __('Character Set', 'myarcadetheme'),
        'content' => __( "Choose the character sets you want.", 'myarcadetheme' ),
      ),
      'options'   => array(
        'cyrillic'      => __('Cyrillic', 'myarcadetheme'),
        'cyrillic-ext'  => __('Cyrillic Extended', 'myarcadetheme'),
        'greek' => __('Greek', 'myarcadetheme'),
        'greek-ext' => __('Greek Extended', 'myarcadetheme'),
        'latin' => __('Latin', 'myarcadetheme'),
        'latin-ext' => __('Latin Extended', 'myarcadetheme'),
        'vietnamese' => __('Vietnamese', 'myarcadetheme'),
      ),
      'default'   => 'latin',
    ),

    array(
      'id' => 'admin_bar',
      'type' => 'switch',
      'title' => __('Admin Bar', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Admin Bar", 'myarcadetheme'),
        'content' => __("If disabled, the top admin bar will be hidden.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
  )
) );

// Header & Footer
myarcadetheme_redux_set_section( $opt_name, array(
  'icon'      => 'el-icon-website',
  'title'     => __('Header & Footer', 'myarcadetheme'),
  'fields'    => array(
    array(
      'id' => 'favicon',
      'type' => 'media',
      'title' => __('Favicon', 'myarcadetheme'),
      'hint' => array(
        'title'   => __( "Upload a custom favicon", 'myarcadetheme' ),
        'content' => __( "This option allows you to upload your own favorite icon.", 'myarcadetheme' ),
      ),
      'default'  => array(
        'url'=> get_template_directory_uri().'/images/favico.ico',
      ),
    ),

    array(
      'id' => 'logohd',
      'type' => 'media',
      'preview'=> false,
      'title' => __('Logo', 'myarcadetheme'),
      'hint' => array(
        'title'   => __( "Upload a custom logo", 'myarcadetheme' ),
        'content' => __( "This option allows you to upload your own logo.", 'myarcadetheme' ),
      ),
      'default'  => array(
        'url'=> get_template_directory_uri().'/images/my-arcade-theme.png',
      ),
    ),

    array(
      'id' => 'logoft',
      'type' => 'media',
      'preview'=> false,
      'title' => __('Footer Logo', 'myarcadetheme'),
      'hint' => array(
        'title'   => __( "Upload a custom footer logo", 'myarcadetheme' ),
        'content' => __( "This option allows you to upload your own logo for the footer Widget.", 'myarcadetheme' ),
      ),
      'default'  => array(
        'url'=> get_template_directory_uri().'/images/my-arcade-theme-ft.png',
      ),
    ),

    array(
      'id' => 'logologin',
      'type' => 'media',
      'preview'=> false,
      'title' => __('Login Logo', 'myarcadetheme'),
      'hint' => array(
        'title'   => __( "Upload a custom login logo", 'myarcadetheme' ),
        'content' => __( "This option allows you to upload your own login logo. It you don't upload a custom login logo your main logo will be displayed on the login page.", 'myarcadetheme' ),
      ),
    ),

    array(
      'id' => 'slider_header',
      'type' => 'switch',
      'title' => __('Carousel Slider', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Carousel Slider', 'myarcadetheme'),
        'content' => __( 'This slider is displayed on all pages just below the menu bar.', 'myarcadetheme'),
      ),
      "default" => 1,
      'on' => __('Show', 'myarcadetheme'),
      'off' => __('Hide', 'myarcadetheme'),
    ),

    array(
      'id' => 'section_header_slider_start',
      'type' => 'section',
      'indent' => true,
      'required' => array('slider_header','equals','1'),
    ),

    array(
      'id' => 'categories_sliderhd',
      'type' => 'select',
      'data' => 'categories',
      'multi' => true,
      'empty' => true,
      'title' => __( 'Categories' , 'myarcadetheme'),
      'hint' => array(
        'title' => __( 'Categories', 'myarcadetheme'),
        'content' => __( 'Select game categories that should be displayed on this slider.', 'myarcadetheme') . ' ' . __('Leave empty in order to display games from all categories.' , 'myarcadetheme'),
      ),
      'required' => array('slider_header','equals','1'),
      ),

    array(
      'id' => 'sortable_sliderhd',
      'type' => 'spinner',
      'title' => __('Number of slides', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Number of slides', 'myarcadetheme'),
        'content' => __( 'Set how many games should be displayed on the slider. (Default: 20)', 'myarcadetheme'),
      ),
      'default' => "20",
      "min"       => "3",
      "step"      => "1",
      "max"       => "50",
      'required' => array('slider_header','equals','1'),
      ),

      array(
        'id' => 'related_sliderhd',
        'type' => 'switch',
        'title' => __('Related Games', 'myarcadetheme'),
        'hint' => array(
          'title' => __('Related Games On Single View', 'myarcadetheme'),
          'content' => __( 'Display related games in the slider on the game play page.', 'myarcadetheme'),
        ),
        "default" => 0,
        'on' => __('Yes', 'myarcadetheme'),
        'off' => __('No', 'myarcadetheme'),
      ),

    array(
      'id' => 'section_header_slider_end',
      'type' => 'section',
      'indent' => false,
      'required' => array('slider_header','equals','1'),
    ),

    array(
      'id' => 'slider_news',
      'type' => 'switch',
      'title' => __('News Ticker', 'myarcadetheme'),
      'hint' => array(
        'title' => __('News Ticker', 'myarcadetheme'),
        'content' => __( 'The news ticker is displayed on the bottom of the header. It displays last published games from a selected category.', 'myarcadetheme'),
      ),
      "default" => 1,
      'on' => __('Show', 'myarcadetheme'),
      'off' => __('Hide', 'myarcadetheme'),
    ),

    array(
      'id' =>'section_newsticker_start',
      'type' => 'section',
      'indent' => true,
      'required' => array('slider_news','equals','1'),
    ),

    array(
      'id' =>'categories_slidernews',
      'type' => 'select',
      'data' => 'categories',
      'multi' => true,
      'empty' => true,
      'title' => __( 'Categories', 'myarcadetheme'),
      'hint' => array(
        'title' => __( 'Categories', 'myarcadetheme'),
        'content' => __( 'Select game categories that should be displayed on the news ticker.', 'myarcadetheme') . ' ' . __('Leave empty in order to display games from all categories.' , 'myarcadetheme'),
      ),
      'required' => array('slider_news','equals','1'),
    ),

    array(
      'id' => 'sortable_slidernews',
      'type' => 'spinner',
      'title' => __( 'Number of news', 'myarcadetheme' ),
      'hint' => array(
        'title' => __( 'Number of news', 'myarcadetheme' ),
        'content' => __( 'Set how many news should be displayed on the news ticker.', 'myarcadetheme' ),
      ),
      'default' => "10",
      "min"       => "3",
      "step"      => "1",
      "max"       => "50",
      'required' => array('slider_news','equals','1'),
    ),

    array(
      'id' => 'section_newsticker_end',
      'type' => 'section',
      'indent' => false,
      'required' => array('slider_news','equals','1'),
    ),


    array(
      'id' => 'custom_header_code',
      'type' => 'ace_editor',
      'mode'     => 'html',
      'theme'    => 'chrome',
      'title' => __('Header Code', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Header Code', 'myarcadetheme'),
        'content' => __("At this field you can add custom JavaScript, CSS or other code that should be added in the header.", 'myarcadetheme'),
      ),
      'default' => ''
      ),

    array(
      'id' => 'custom_footer_code',
      'type' => 'ace_editor',
      'mode'     => 'html',
      'theme'    => 'chrome',
      'title' => __('Footer Code', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Footer Code', 'myarcadetheme'),
        'content' => __("At this field you can add custom JavaScript, CSS or other code that should be added in the footer.", 'myarcadetheme'),
      ),
      'default' => ''
    ),

    array(
      'id' => 'footer_widgets',
      'type' => 'switch',
      'title' => __('Footer Widgets', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Footer Widgets", 'myarcadetheme'),
        'content' => __("Display or hide footer widgets.", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
  )
) );

myarcadetheme_redux_set_section( $opt_name, array(
 'icon' => 'el-icon-website',
 'title' => __('Header Layout', 'myarcadetheme'),
 'subsection' => true,
 'fields' => array(
  array(
    'id' => 'header_layout',
    'type' => 'select',
    'title' => __('Header Layout', 'myarcadetheme'),
    'hint' => array(
      'title'   => __('Header Layout', 'myarcadetheme'),
      'content' => __( "Select between several header layouts.", 'myarcadetheme' ),
    ),
    'options'  => array(
      '1' => __("Magazine Style", 'myarcadetheme'),
      '2' => __("Horizontal Single Line (Pro)", 'myarcadetheme'),
    ),
    "default" => '1',
  ),

  /** Magazine Header Settings */
  array(
    'id' => 'randomgame',
    'type' => 'switch',
    'title' => __('Random Game Button', 'myarcadetheme'),
    'hint' => array(
      'title' => __( "Random Game Button", 'myarcadetheme' ),
      'content' => __("Display or hide the random games button on the menu bar.", 'myarcadetheme'),
    ),
    "default" => 1,
    'on' => __('Show', 'myarcadetheme'),
    'off' => __('Hide', 'myarcadetheme'),
    'required' => array( 'header_layout','equals','1'),
  ),

  array(
    'id' => 'topbar',
    'type' => 'switch',
    'title' => __('Top Bar', 'myarcadetheme'),
    'hint' => array(
      'title'   => __('Top Bar', 'myarcadetheme'),
      'content' => __( "Display the top bar above your header.", 'myarcadetheme' ),
    ),
    "default" => 1,
    'on' => __('Show', 'myarcadetheme'),
    'off' => __('Hide', 'myarcadetheme'),
    'required' => array( 'header_layout', 'equals','1' ),
  ),

  array(
    'id' => 'section_topbar_start',
    'type' => 'section',
    'indent' => true,
    'required' => array(
      array( 'header_layout', 'equals','1' ),
      array( 'topbar', 'equals', '1' ),
    ),
  ),

  array(
    'id' => 'topbar_heading',
    'type' => 'switch',
    'title' => __('Heading', 'myarcadetheme'),
    'hint' => array(
      'title'   => __('Heading', 'myarcadetheme'),
      'content' => __( "Display a dynamic heading on the left side of the top bar.", 'myarcadetheme' ),
    ),
    "default" => 1,
    'on' => __('Show', 'myarcadetheme'),
    'off' => __('Hide', 'myarcadetheme'),
    'required' => array(
      array( 'header_layout', 'equals','1' ),
      array( 'topbar', 'equals', '1' ),
    ),
  ),

  array(
    'id' => 'topbar_login',
    'type' => 'select',
    'title' => __('Login Link', 'myarcadetheme'),
    'hint' => array(
      'title'   => __('Login Link', 'myarcadetheme'),
      'content' => __( "Display a login button on the top bar. Select 'Link' if you use e.g. a captcha plugin.", 'myarcadetheme' ),
    ),
    'options'  => array(
      '1' => __("Modal Box", 'myarcadetheme'),
      '2' => __("Link", 'myarcadetheme'),
      '0' => __("Hide", 'myarcadetheme'),
    ),
    "default" => 1,
    'required' => array(
      array( 'header_layout', 'equals','1' ),
      array( 'topbar', 'equals', '1' ),
    ),
  ),

  array(
    'id' => 'topbar_register',
    'type' => 'select',
    'title' => __('Register Link', 'myarcadetheme'),
    'hint' => array(
      'title'   => __('Register Link', 'myarcadetheme'),
      'content' => __( "Display a register button on the top bar. Select 'Link' if you use e.g. a captcha plugin.", 'myarcadetheme' ),
    ),
    'options'  => array(
      '1' => __("Modal Box", 'myarcadetheme'),
      '2' => __("Link", 'myarcadetheme'),
      '0' => __("Hide", 'myarcadetheme'),
    ),
    "default" => 1,
    'required' => array(
      array( 'header_layout', 'equals','1' ),
      array( 'topbar', 'equals', '1' ),
    ),
  ),

  array(
    'id' => 'topbar_search',
    'type' => 'switch',
    'title' => __('Search', 'myarcadetheme'),
    'hint' => array(
      'title'   => __('Search', 'myarcadetheme'),
      'content' => __( "Display the search button on the top bar.", 'myarcadetheme' ),
    ),
    "default" => 1,
    'on' => __('Show', 'myarcadetheme'),
    'off' => __('Hide', 'myarcadetheme'),
    'required' => array(
      array( 'header_layout', 'equals','1' ),
      array( 'topbar', 'equals', '1' ),
    ),
  ),

  array(
    'id' => 'topbar_share',
    'type' => 'switch',
    'title' => __('Share Icons', 'myarcadetheme'),
    'hint' => array(
      'title'   => __('Share Icons', 'myarcadetheme'),
      'content' => __( "Display share icons on the top bar.", 'myarcadetheme' ),
    ),
    "default" => 1,
    'on' => __('Show', 'myarcadetheme'),
    'off' => __('Hide', 'myarcadetheme'),
    'required' => array(
      array( 'header_layout', 'equals','1' ),
      array( 'topbar', 'equals', '1' ),
    ),
  ),

  array(
    'id' => 'section_topbar_end',
    'type' => 'section',
    'indent' => false,
    'required' => array(
      array( 'header_layout', 'equals','1' ),
      array( 'topbar', 'equals', '1' ),
    ),
  ),

  array(
    'id' => 'horizontal_header_login',
    'type' => 'select',
    'title' => __('Login Link', 'myarcadetheme'),
    'hint' => array(
      'title'   => __('Login Link', 'myarcadetheme'),
      'content' => __( "Display a login button on the header. Select 'Link' if you use e.g. a captcha plugin.", 'myarcadetheme' ),
    ),
    'options'  => array(
      '1' => __("Modal Box", 'myarcadetheme'),
      '2' => __("Link", 'myarcadetheme'),
      '0' => __("Hide", 'myarcadetheme'),
    ),
    "default" => 1,
    'required' => array(
      array( 'header_layout', 'equals','2' ),
    ),
  ),
 )
));

// Front Page
myarcadetheme_redux_set_section( $opt_name, array(
  'icon'      => 'el-icon-home',
  'title'     => __('Front Page', 'myarcadetheme'),
  'fields'    => array(

    array(
      'id' => 'slider_home',
      'type' => 'switch',
      'title' => __('Home Slider', 'myarcadetheme'),
      'hint' => array(
        'title'   => __( 'Home Slider', 'myarcadetheme'),
        'content' => __( 'This slider is displayed the front page just below the header. ', 'myarcadetheme'),
      ),
      "default" => 1,
      'on' => __('Show', 'myarcadetheme'),
      'off' => __('Hide', 'myarcadetheme'),
    ),

    array(
      'id' => 'section_home_slider_start',
      'type' => 'section',
      'indent' => true,
      'required' => array('slider_home','equals','1'),
    ),

    array(
      'id' => 'categories_sliderft',
      'type' => 'select',
      'data' => 'categories',
      'multi' => true,
      'empty' => true,
      'title' => __( 'Categories' , 'myarcadetheme'),
      'hint' => array(
        'title' => __( 'Categories', 'myarcadetheme'),
        'content' => __( 'Select game categories that should be displayed on this slider.', 'myarcadetheme') . ' ' . __('Leave empty in order to display games from all categories.' , 'myarcadetheme'),
      ),
      'required' => array('slider_home','equals','1'),
    ),

    array(
      'id' => 'gamecount_sliderft',
      'type' => 'spinner',
      'title' => __('Number of slides', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Number of slides', 'myarcadetheme'),
        'content' => __( 'Set how many games should be displayed on the slider. (Default: 10)', 'myarcadetheme'),
      ),
      'default' => "10",
      "min"       => "1",
      "step"      => "1",
      "max"       => "50",
      'required' => array('slider_home','equals','1'),
    ),

    array(
      'id' => 'section_home_slider_end',
      'type' => 'section',
      'indent' => false,
      'required' => array('slider_home','equals','1'),
    ),

    array(
      'id' => 'promoted_games',
      'type' => 'switch',
      'title' => __('Promoted Games', 'myarcadetheme'),
      'hint' => array(
        'title'   => __( 'Promoted Games', 'myarcadetheme'),
        'content' => __( 'Display a sortable games box. ', 'myarcadetheme'),
      ),
      "default" => 1,
      'on' => __('Show', 'myarcadetheme'),
      'off' => __('Hide', 'myarcadetheme'),
    ),

    array(
      'id' => 'section_promoted_games_start',
      'type' => 'section',
      'indent' => true,
      'required' => array('promoted_games','equals','1'),
    ),

    array(
      'id' => 'promoted_title',
      'type' => 'text',
      'title' => __('Title', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Title", 'myarcadetheme'),
        'content' => __("Set a title for the 'Promoted Games Box'.", 'myarcadetheme' ) . ' ' . __( "This will be used for the Kizi-Style layout, too.", 'myarcadetheme'),
      ),
      'default' => 'PROMOTED GAMES',
    ),

    array(
      'id' => 'promoted_categories',
      'type' => 'select',
      'data' => 'categories',
      'multi' => true,
      'empty' => true,
      'title' => __( 'Categories' , 'myarcadetheme'),
      'hint' => array(
        'title' => __( 'Categories', 'myarcadetheme'),
        'content' => __( 'Select game categories that should be displayed on the promoted games box.', 'myarcadetheme') . ' ' . __('Leave empty in order to display games from all categories.' , 'myarcadetheme'),
      ),
      'required' => array('promoted_games','equals','1'),
    ),

    array(
      'id' => 'promoted_gamecount',
      'type' => 'spinner',
      'title' => __('Number of games', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Number of games', 'myarcadetheme'),
        'content' => __( 'Set how many games should be displayed on the promoted games box. (Default: 10)', 'myarcadetheme'),
      ),
      'default' => "10",
      "min"       => "1",
      "step"      => "1",
      "max"       => "50",
      'required' => array('promoted_games','equals','1'),
    ),

    array(
      'id'        => 'promoted_order',
      'type'      => 'select',
      'title'     => __('Game order', 'myarcadetheme'),
      'subtitle'  => __('Set the preferred game order for the promoted games box.', 'myarcadetheme'),
      'options'   => array(
        1 => __('Newest First', 'myarcadetheme'),
        2 => __('Oldest First', 'myarcadetheme'),
        3 => __('Highest Rated', 'myarcadetheme'),
        4 => __('Most Played', 'myarcadetheme'),
        5 => __('Most Discussed', 'myarcadetheme'),
        6 => __('Alphabetically (A-Z)', 'myarcadetheme'),
        7 => __('Alphabetically (Z-A)', 'myarcadetheme'),
      ),
      'default'   => 1,
    ),

    array(
      'id' => 'section_promoted_games_end',
      'type' => 'section',
      'indent' => false,
      'required' => array('promoted_games','equals','1'),
    ),

    array(
      'id'        => 'box_design',
      'type'      => 'select',
      'title'     => __('Design', 'myarcadetheme'),
      'hint'      => array(
        'title' => __('Design', 'myarcadetheme'),
        'content' => __( "Select a front page design.", 'myarcadetheme' ),
      ),
      'options'   => array(
        'full'          => __('Full Width Boxes', 'myarcadetheme'),
        'builder'       => __('Front Page Builder (Pro)', 'myarcadetheme'),
        'friv'          => __('Friv-Style (Pro)', 'myarcadetheme'),
        'friv-sidebar'  => __('Friv-Style with Sidebar (Pro)', 'myarcadetheme'),
        'half'          => __('Half Width Boxes (Pro)', 'myarcadetheme'),
        'horizontal'    => __('Horizontal Boxes (Pro)', 'myarcadetheme'),
        'vertical'      => __('Vertical Boxes (Pro)', 'myarcadetheme')
      ),
      'default'   => 'full',
    ),

    array(
      'id' => 'builder_info',
      'type'  => 'info',
      'style' => 'warning',
      'desc' => __('To use the "Front Page Builder" navigate to Appearance -> Widgets and add "Builder Widgets" to "Front Page Builder" sidebar', 'myarcadetheme' ),
      'required' => array('box_design','equals','builder'),
    ),

    array(
      'id' => 'section_excludecat_start',
      'type' => 'section',
      'indent' => true,
    ),

    array(
      'id' => 'friv_style_title',
      'type' => 'text',
      'title' => __('Friv-Style Title', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Friv-Style Title', 'myarcadetheme'),
        'content' => __( "Set a title that should be displayed above games in Friv-Style design.", 'myarcadetheme' ),
      ),
      'default' => __('BROWSE OUR GAMES', 'myarcadetheme'),
      'required' => array('box_design','contains','friv'),
    ),

    array(
      'id' => 'posts_per_page_home',
      'type' => 'spinner',
      'title' => __('Game count', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Game count", 'myarcadetheme'),
        'content' => __("Set how many games should be displayed in each category box or on the Friv-Style layout.", 'myarcadetheme'),
      ),
      "default" => 4,
      'required' => array( 'box_design','not','builder' ),
      "min" => "1",
      "step" => "1",
      "max" => "200"
    ),

    array(
      'id' => 'excludecat',
      'type' => 'select',
      'data' => 'categories',
      'multi' => true,
      'title' => __('Exclude categories', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Exclude categories', 'myarcadetheme'),
        'content' => __("Select categories boxes that should NOT be displayed on the front page. This option affects all category designs except the Friv-Style.", 'myarcadetheme' ),
      ),
      'required' => array( 'box_design','not','builder' ),
    ),

    array(
      'id' => 'section_excludecat_end',
      'type' => 'section',
      'indent' => false,
    ),

    array(
      'id' => 'front_page_text_status',
      'type' => 'switch',
      'title' => __('Front Page Text', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Front Page Text', 'myarcadetheme'),
        'content' => __( 'Here you can add some text for SEO purpose or just to introduce your site.', 'myarcadetheme' ),
      ),

      'on' => __('Show', 'myarcadetheme'),
      'off' => __('Hide', 'myarcadetheme'),
      "default" => 1
    ),

    array(
      'id' => 'section_front_page_text_start',
      'type' => 'section',
      'indent' => true,
      'required' => array( 'front_page_text_status', 'equals', '1' ),
    ),

    array(
      'id' => 'front_page_text_title',
      'type' => 'text',
      'title' => __('Title', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Title', 'myarcadetheme'),
        'content' => __( 'Title that should be displayed above the text.', 'myarcadetheme' ),
      ),
      'default' => __('Front Page Text', 'myarcadetheme' ),
    ),

    array(
      'id' => 'front_page_text_content',
      'type' => 'editor',
      'title' => __( 'Content', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Content', 'myarcadetheme'),
        'content' => __( 'Content of the front page text box.', 'myarcadetheme' ),
      ),
      'default' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
    ),

   array(
      'id' => 'section_front_page_text_end',
      'type' => 'section',
      'indent' => false,
      'required' => array( 'front_page_text_status', 'equals', '1' ),
    ),

    array(
      'id' => 'hall_of_fame',
      'type' => 'switch',
      'title' => __('Hall Of Fame', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Hall Of Fame', 'myarcadetheme'),
        'content' => __( "Show the best players of your site.", 'myarcadetheme' ),
      ),

      'on' => __('Show', 'myarcadetheme'),
      'off' => __('Hide', 'myarcadetheme'),
      "default" => 1
    ),

    array(
      'id' => 'section_fame_start',
      'type' => 'section',
      'indent' => true,
      'required' => array('hall_of_fame','equals','1'),
    ),

    array(
      'id' => 'hall_of_fame_title',
      'type' => 'text',
      'title' => __('Hall Of Fame Title', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Hall Of Fame Title', 'myarcadetheme'),
        'content' => __( "Set a title for the 'Hall of Fame' box.", 'myarcadetheme' ),
      ),
      'default' => __('Hall Of Fame', 'myarcadetheme'),
      'required' => array('hall_of_fame','equals','1'),
    ),

    array(
      'id' => 'section_fame_end',
      'type' => 'section',
      'indent' => false,
      'required' => array('hall_of_fame','equals','1'),
    ),
  )
) );

// Blog Archive
myarcadetheme_redux_set_section( $opt_name, array(
  'title'     => __('Blog Archive', 'myarcadetheme'),
  'desc'      => sprintf( __('%sThis section customizes the blog archive page.%s', 'myarcadetheme'), '<p class="description">', '</p>'),
  'icon'      => 'el el-file-edit',
  'fields'    => array(
    array(
      'id' => 'blogcat',
      'type' => 'select',
      'data' => 'categories',
      'args' => array( 'hide_empty' => 0 ),
      'multi' => false,
      'title' => __('Blog category', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Blog Category", 'myarcadetheme'),
        'content' => __("Select a category that should be used as the regular blog.", 'myarcadetheme' )
      ),
    ),
    array(
      'id' => 'blog_archive_breadcrumbs',
      'type' => 'switch',
      'title' => __('Blog Archive Breadcrumbs', 'myarcadetheme'),
  		'hint' => array(
        'title' => __('Blog Archive Breadcrumbs', 'myarcadetheme'),
        'content' => __( "Enable or disable the blog archive breadcrumbs", 'myarcadetheme' ),
       ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
    array(
      'id' => 'blogcat_desc',
      'type' => 'switch',
      'title' => __('Blog Category Description', 'myarcadetheme'),
  		'hint' => array(
        'title' => __('Blog Categoryy Description', 'myarcadetheme'),
        'content' => __( "Enable or disable the blog archive category description.", 'myarcadetheme' ),
       ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
    array(
      'id' => 'blogcat_desc_expand',
      'type' => 'switch',
      'title' => __('Description Expandable', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Blog Description Expandable", 'myarcadetheme'),
        'content' => __("If enabled, there will be an option to expand/collapse the blog archive description box.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
      'required' => array('blogcat_desc','equals','1'),
    ),
  )
) );

// Blog Single Post
myarcadetheme_redux_set_section( $opt_name, array(
  'title'     => __('Blog Single Post', 'myarcadetheme'),
  'desc'      => sprintf( __('%sThis section customizes the blog single post.%s', 'myarcadetheme'), '<p class="description">', '</p>'),
  'subsection' => true,
  'icon'      => 'el el-file-edit',
  'fields'    => array(
    array(
      'id' => 'single_post_featured_image',
      'type' => 'switch',
      'title' => __('Featured Image', 'myarcadetheme'),
  		'hint' => array(
        'title' => __('Single Post Authorbox', 'myarcadetheme'),
        'content' => __( "Enable or disable the featured image from showing on your single posts.", 'myarcadetheme' ),
       ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
    array(
      'id' => 'single_post_author_box',
      'type' => 'switch',
      'title' => __('Author Box', 'myarcadetheme'),
  		'hint' => array(
        'title' => __('Single Post Authorbox', 'myarcadetheme'),
        'content' => __( "Enable or disable the single post authorbox.", 'myarcadetheme' ),
       ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
    array(
      'id' => 'single_post_breadcrumbs',
      'type' => 'switch',
      'title' => __('Single Post Breadcrumbs', 'myarcadetheme'),
  		'hint' => array(
        'title' => __('Single Post Breadcrumbs', 'myarcadetheme'),
        'content' => __( "Enable or disable the single post breadcrumbs.", 'myarcadetheme' ),
       ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
    array(
      'id' => 'single_post_comments',
      'type' => 'switch',
      'title' => __('Single Post Comments', 'myarcadetheme'),
  		'hint' => array(
        'title' => __('Single Post Comments', 'myarcadetheme'),
        'content' => __( "Enable or disable the single post comments.", 'myarcadetheme' ),
       ),      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
  )
) );

// Pre-Game Page
myarcadetheme_redux_set_section( $opt_name, array(
  'title'     => __('Games Page', 'myarcadetheme'),
  'desc'      => sprintf( __('%sThis section customizes the pre-game presentation your site.%s', 'myarcadetheme'), '<p class="description">', '</p>'),
  'icon'      => 'el-icon-eye-open',
  'fields'    => array(
    array(
      'id' => 'pregame',
      'type' => 'switch',
      'title' => __('Pre-Game Page (Pro)', 'myarcadetheme'),
      'desc'=> __('Enable this if you want to display a pre-game / game landing page. User will need to click on a play button.', 'myarcadetheme'),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
      ),

    array(
      'id' => 'section_pregame_start',
      'type' => 'section',
      'indent' => true,
      'required' => array('pregame','equals','1'),
    ),

    array(
      'id' => 'game_play_permalink_endpoint',
      'type' => 'text',
      'title' => __('Game Play Permalink Endpoint', 'myarcadetheme'),
      'subtitle' => __("Define the permalink endpoint for the game play page.", 'myarcadetheme'),
      'desc' => sprintf( __('When you change this then you MUST visit the %sPermalinks Settings%s page once!', 'myarcadetheme'), '<a target="_blank" href="'.home_url().'/wp-admin/options-permalink.php">', '</a>'),
      'default' => 'play',
      'required' => array('pregame','equals','1'),
      ),

    array(
      'id' => 'stop_indexing',
      'type' => 'switch',
      'title' => __('Stop Indexing Play Page', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Stop Indexing Play Page", 'myarcadetheme'),
        'content' => __("This option will prevent search enginges from indexing the play game page to avoid duplicate content.", 'myarcadetheme' )
      ),
      "default" => 0,
      'required' => array('pregame','equals','1'),
    ),

    array(
      'id' => 'myscorepresenter_widget',
      'type' => 'switch',
      'title' => __('MyScorePresenter Widgets', 'myarcadetheme'),
      'desc'=> __("Enable this if you wish to enable MyScorePresenter widgets on the Pre-Game page. ", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'myarcadecontrols',
      'type' => 'switch',
      'title' => __('Game Controls', 'myarcadetheme'),
      'desc'=> __("Enable this if you want to display game controls on single game pages (MyArcadeControls Plugin required)", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'display_video',
      'type' => 'switch',
      'title' => __('Game Video', 'myarcadetheme'),
      'desc'=> __("Enable this if you want to display a game video on single game pages (only when available)", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'display_screenshots',
      'type' => 'switch',
      'title' => __('Screen Shots', 'myarcadetheme'),
      'desc'=> __("Enable this if you want to display game screenshots on single game pages (only when available)", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

  array(
      'id' => 'veedi',
      'type' => 'switch',
      'title' => __('Veedi Integration', 'myarcadetheme'),
      'desc'=> __('Enable this option if you want to activate Veedi integration.', 'myarcadetheme'),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
      ),

    array(
      'id'        => 'veedi_publisherid',
      'type'      => 'text',
      'title'     => __('Veedi Publisher ID', 'myarcadetheme'),
      'desc'      => __('Enter your Veedi Publisher ID.', 'myarcadetheme'),
      'required' => array('veedi','equals','1'),
      ),


    array(
      'id' => 'game_embed_box',
      'type' => 'switch',
      'title' => __('Game Embed Box', 'myarcadetheme'),
      'desc'=> __("Enable or disable the game embed box ('Embed this game on your site..').", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'game_related_games',
      'type' => 'switch',
      'title' => __('Related Games', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of related games.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'game_comments',
      'type' => 'switch',
      'title' => __('Game Comments', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of comments on the pre-game page.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'pregame_meta_category',
      'type' => 'switch',
      'title' => __('Meta Field - Category', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of the game category.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'pregame_meta_author',
      'type' => 'switch',
      'title' => __('Meta Field - Author', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of the game post author name.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'pregame_meta_date',
      'type' => 'switch',
      'title' => __('Meta Field - Date', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of the game post creation date.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'pregame_meta_comment_count',
      'type' => 'switch',
      'title' => __('Meta Field - Comment Count', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of the game comment count.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'section_pregame_end',
      'type' => 'section',
      'indent' => false,
      'required' => array('pregame','equals','1'),
    ),
  )
) );

// Play Game Page
myarcadetheme_redux_set_section( $opt_name, array(
  'title'     => __('Play Game Page', 'myarcadetheme'),
  'desc'      => sprintf( __('%sThis section customizes the play game page of your site.%s', 'myarcadetheme'), '<p class="description">', '</p>'),
  'subsection' => true,
  'icon'      => 'el-icon-play',
  'fields'    => array(

    array(
      'id'       => 'game_layout',
      'type'     => 'image_select',
      'title'    => __('Game Layout (Pro)', 'myarcadetheme'),
      'subtitle' => __('Select game and sidebar alignment. Choose between full witdh, single sidebar or double sidebar layout.', 'myarcadetheme'),
      'class' => 'myarcadtheme_image_select',
      'options'  => array(
          '1'      => array(
              'alt'   => __('Full Width', 'myarcadetheme' ),
              'img'   => ReduxFramework::$_url.'assets/img/1col.png',
          ),
          '2'      => array(
              'alt'   => 'Left sidebar',
              'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
          ),
          '3'      => array(
              'alt'   => 'Right sidebar',
              'img'  => ReduxFramework::$_url.'assets/img/2cr.png'
          ),
          '4'      => array(
              'alt'   => 'Two sidbars',
              'img'   => ReduxFramework::$_url.'assets/img/3cm.png'
          ),
      ),
      'default' => '1'
    ),

    array(
      'id'      => 'play_game_layout',
      'type'    => 'sorter',
      'title'   => __('Game Page Content Layout (Pro)', 'myarcadetheme'),
      'desc'    => __('Organize how you want the layout to appear on the play games page.', 'myarcadetheme'),
      'options' => array(
        'disabled' => array(

          'tags'     => __('Game Tags', 'myarcadetheme'),
          'related'  => __('Related Games', 'myarcadetheme'),
          'veedi'    => __('Veedi (if available)', 'myarcadetheme'),
        ),
        'enabled' => array(
          'content'     => __('Content / Description', 'myarcadetheme'),
          'controls'    => __('MyArcadeControls Integration' ),
          'video'       => __('Game Video (if available) ', 'myarcadetheme'),
          'screenshots' => __('Game Screenshots ', 'myarcadetheme'),
          'embed'       => __('Embed game box ', 'myarcadetheme'),
          'comments'    => __('Game comments ', 'myarcadetheme'),
        )
      )
    ),

    array(
      'id' => 'game_buttons',
      'type' => 'select',
      'title' => __('Game Buttons', 'myarcadetheme'),
      'desc'=> __("Select where do you like to display game buttons.", 'myarcadetheme'),
      "default" => 1,
      'options' => array(
        1 => __( 'Bellow the game', 'myarcadetheme' ),
        2 => __( 'Above the game', 'myarcadetheme' ),
      ),
    ),

    array(
      'id' => 'fullscreen',
      'type' => 'select',
      'title' => __('Fullscreen Feature (Pro)', 'myarcadetheme'),
      'desc'=> __("Select which kind of fullscreen button you want to enable.", 'myarcadetheme'),
      "default" => 3,
      'options' => array(
        1 => __( 'JavaScript (without page reload) (Pro)', 'myarcadetheme' ),
        2 => __( 'PHP (with page reload) (Pro)', 'myarcadetheme' ),
        3 => __( 'Disable Fullscreen', 'myarcadetheme')
      ),
    ),

    array(
      'id' => 'lights_button',
      'type' => 'switch',
      'title' => __('Lights On / Off Button', 'myarcadetheme'),
      'desc'=> __("Enable this if you want to display the lights button.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'favorite_button',
      'type' => 'switch',
      'title' => __('Favorite Button', 'myarcadetheme'),
      'desc'=> __("Enable this if you want to display the favorite button (WP Favorite Posts plugin reqired).", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'report_button',
      'type' => 'switch',
      'title' => __('Report Button', 'myarcadetheme'),
      'desc'=> __("Enable this if you want to report button (Links/Problem Reporter plugin required).", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'share_button',
      'type' => 'switch',
      'title' => __('Share Button', 'myarcadetheme'),
      'desc'=> __("Enable this if you want to display the share button.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id'        => 'play_veedi_publisherid',
      'type'      => 'text',
      'title'     => __('Veedi Publisher ID (optional)', 'myarcadetheme'),
      'desc'      => __('Enter your Veedi Publisher ID if you want to display Veedi walktrough videos.', 'myarcadetheme'),
    ),

    array(
      'id' => 'play_meta_category',
      'type' => 'switch',
      'title' => __('Meta Field - Category', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of the game category.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'play_meta_author',
      'type' => 'switch',
      'title' => __('Meta Field - Author', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of the game post author name.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'play_meta_date',
      'type' => 'switch',
      'title' => __('Meta Field - Date', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of the game post creation date.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'play_meta_comment_count',
      'type' => 'switch',
      'title' => __('Meta Field - Comment Count', 'myarcadetheme'),
      'desc'=> __("Enable or disable the displaying of the game comment count.", 'myarcadetheme'),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
  )
) );

// Category Pages
myarcadetheme_redux_set_section( $opt_name, array(
  'id' => 'category_options',
  'title'     => __('Category Page', 'myarcadetheme'),
  'desc'      => sprintf( __('%sThis section customizes the category page of your site.%s', 'myarcadetheme'), '<p class="description">', '</p>'),
  'icon'      => 'el-icon-folder',
  'fields'    => array(
    array(
      'id' => 'posts_per_page',
      'type' => 'spinner',
      'title' => __( "Game count", 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Games per category page", 'myarcadetheme'),
        'content' => __( "Set how many games should be displayed per category page. This overrides the WordPress option 'Blog pages show at most'.", 'myarcadetheme'),
      ),
      "default" => get_option('posts_per_page'),
      "min" => "1",
      "step" => "1",
      "max" => "100"
    ),

    array(
      'id' => 'posts_per_category_cloud',
      'type' => 'spinner',
      'title' => __( "Category Cloud Game Count", 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Category Cloud Games Count", 'myarcadetheme'),
        'content' => __( "Set how many games should be displayed on the category cloud widget.", 'myarcadetheme'),
      ),
      "default" => 25,
      "min" => "1",
      "step" => "1",
      "max" => "100"
    ),

    array(
      'id' => 'cat_desc',
      'type' => 'switch',
      'title' => __('Category Description', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Category Description", 'myarcadetheme'),
        'content' => __("If enabled, a category description will be displayed on game categpry pages.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'cat_desc_expand',
      'type' => 'switch',
      'title' => __('Description Expandable', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Category Description Expandable", 'myarcadetheme'),
        'content' => __("If enabled, there will be an option to expand/collapse the category description box.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
      'required' => array('cat_desc','equals','1'),
    ),

    array(
      'id' => 'cat_breadcrumbs',
      'type' => 'switch',
      'title' => __('Category Breadcrumbs', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Category Breadcrumbs", 'myarcadetheme'),
        'content' => __("If enabled, enabled breadcrumbs will be displayed on the category pages.", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id'        => 'archive_design',
      'type'      => 'select',
      'title'     => __('Layout', 'myarcadetheme'),
      'subtitle'  => __('Select a preferred layout option for category pages.', 'myarcadetheme'),
      'options'   => array(
        1 => __('Small', 'myarcadetheme'),
        2 => __('Large', 'myarcadetheme'),
        3 => __('Grid', 'myarcadetheme'),
        4 => __('Half', 'myarcadetheme'),
      ),
      'default'   => 3,
    ),

    array(
      'id'        => 'archive_order',
      'type'      => 'select',
      'title'     => __('Game order', 'myarcadetheme'),
      'subtitle'  => __('Set the preferred game order for category pages.', 'myarcadetheme'),
      'options'   => array(
        1 => __('Newest First', 'myarcadetheme'),
        2 => __('Oldest First', 'myarcadetheme'),
        3 => __('Highest Rated', 'myarcadetheme'),
        4 => __('Most Played', 'myarcadetheme'),
        5 => __('Most Discussed', 'myarcadetheme'),
        6 => __('Alphabetically (A-Z)', 'myarcadetheme'),
        7 => __('Alphabetically (Z-A)', 'myarcadetheme'),
      ),
      'default'   => 1,
    ),
  )
) );

// Tag Pages
myarcadetheme_redux_set_section( $opt_name, array(
  'id' => 'tag_options',
  'title'     => __('Tag Page', 'myarcadetheme'),
  'desc'      => sprintf( __('%sThis section customizes the tag page of your site.%s', 'myarcadetheme'), '<p class="description">', '</p>'),
  'subsection' => true,
  'icon'      => 'el-icon-tag',
  'fields'    => array(
    array(
      'id' => 'posts_per_tag_page',
      'type' => 'spinner',
      'title' => __( "Game count", 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Games per tag page", 'myarcadetheme'),
        'content' => __( "Set how many games should be displayed per tag page. This overrides the WordPress option 'Blog pages show at most'.", 'myarcadetheme'),
      ),
      "default" => get_option('posts_per_page'),
      "min" => "1",
      "step" => "1",
      "max" => "100"
    ),

    array(
      'id' => 'posts_per_tag_cloud',
      'type' => 'spinner',
      'title' => __( "Tag Cloud Game Count", 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Tag Cloud Games Count", 'myarcadetheme'),
        'content' => __( "Set how many games should be displayed on the tag cloud widget.", 'myarcadetheme'),
      ),
      "default" => 25,
      "min" => "1",
      "step" => "1",
      "max" => "100"
    ),

    array(
      'id' => 'tag_desc',
      'type' => 'switch',
      'title' => __('Tag Description', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Tag Description", 'myarcadetheme'),
        'content' => __("If enabled, a tag description will be displayed on game tag pages.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'tag_desc_expand',
      'type' => 'switch',
      'title' => __('Description Expandable', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Tag Description Expandable", 'myarcadetheme'),
        'content' => __("If enabled, there will be an option to expand/collapse the tag description box.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
      'required' => array('tag_desc','equals','1'),
    ),

    array(
      'id' => 'tag_breadcrumbs',
      'type' => 'switch',
      'title' => __('Tag Breadcrumbs', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Tag Breadcrumbs", 'myarcadetheme'),
        'content' => __("If enabled, enabled breadcrumbs will be displayed on the tag pages.", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
  )
) );

// Search Pages
myarcadetheme_redux_set_section( $opt_name, array(
  'id' => 'search_options',
  'title'     => __('Search Page', 'myarcadetheme'),
  'desc'      => sprintf( __('%sThis section customizes the search page of your site.%s', 'myarcadetheme'), '<p class="description">', '</p>'),
  'subsection' => true,
  'icon'      => 'el-icon-search',
  'fields'    => array(
    array(
      'id' => 'posts_per_search_page',
      'type' => 'spinner',
      'title' => __( "Game count", 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Games per tag page", 'myarcadetheme'),
        'content' => __( "Set how many games should be displayed per tag page. This overrides the WordPress option 'Blog pages show at most'.", 'myarcadetheme'),
      ),
      "default" => get_option('posts_per_page'),
      "min" => "1",
      "step" => "1",
      "max" => "100"
    ),

    array(
      'id' => 'search_breadcrumbs',
      'type' => 'switch',
      'title' => __('Search Breadcrumbs', 'myarcadetheme'),
      'hint' => array(
        'title' => __( "Search Breadcrumbs", 'myarcadetheme'),
        'content' => __("If enabled, enabled breadcrumbs will be displayed on search pages.", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id'        => 'search_archive_design',
      'type'      => 'select',
      'title'     => __('Layout', 'myarcadetheme'),
      'subtitle'  => __('Select a preferred layout option for search pages.', 'myarcadetheme'),
      'options'   => array(
        1 => __('Small', 'myarcadetheme'),
        2 => __('Large', 'myarcadetheme'),
        3 => __('Grid', 'myarcadetheme'),
        4 => __('Half', 'myarcadetheme'),
      ),
      'default'   => 3,
      /*'desc' => __('For everything to work properly with the chosen color, off Custom CSS', 'myarcadetheme')*/
    ),
  )
) );


// Mobile Settings
myarcadetheme_redux_set_section( $opt_name, array(
  'title'     => __('Mobile Options', 'myarcadetheme'),
  'desc'      => sprintf( __('%sThis section allows you to set the theme behavior for mobile devices.%s', 'myarcadetheme'), '<p class="description">', '</p>'),
  'icon'      => 'el-icon-view-mode',
  'fields'    => array(
    array(
      'id' => 'mobile',
      'type' => 'switch',
      'title' => __('Mobile Games (Pro)', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Mobile games for mobile devices", 'myarcadetheme'),
        'content' => __("If enabled, only games that are tagged with 'mobile' will be displayed if a mobile device has been detected. Otherwise all game types will be displayed for all devices.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'mobile_sidebar',
      'type' => 'switch',
      'title' => __('Hide Sidebar', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Hide Sidebar On Mobile", 'myarcadetheme'),
        'content' => __("If enabled the sidebar will be hidden on mobile devices. This can improve load time and user experience on mobile devices.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'mobile_footer_sidebar',
      'type' => 'switch',
      'title' => __('Hide Footer Sidebar', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Hide Footer Sidebar On Mobile", 'myarcadetheme'),
        'content' => __("If enabled the footer sidebar will be hidden on mobile devices. This can improve load time and user experience on mobile devices.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'mobile_top_bar',
      'type' => 'switch',
      'title' => __('Hide Top Bar', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Hide Header Top Bar On Mobile", 'myarcadetheme'),
        'content' => __("If enabled the top bar will be hidden on mobile devices this can improve user experience.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'mobile_header_carousel',
      'type' => 'switch',
      'title' => __('Hide Header Carousel', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Hide Header Carousel On Mobile", 'myarcadetheme'),
        'content' => __("If enabled the header game carousel will be hidden on mobile devices. This can improve load time and user experience on mobile devices.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'mobile_header_news',
      'type' => 'switch',
      'title' => __('Hide Header News', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Hide Header News On Mobile", 'myarcadetheme'),
        'content' => __("If enabled the header news will be hidden on mobile devices. This can improve load time and user experience on mobile devices.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'mobile_game_list',
      'type' => 'switch',
      'title' => __('Hide Game List', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Hide Game List On Mobile", 'myarcadetheme'),
        'content' => __("If enabled the game list will be hidden on mobile devices. This can improve load time and user experience on mobile devices.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'mobile_slider',
      'type' => 'switch',
      'title' => __('Hide Front Page Slider', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Hide Slider On Mobile", 'myarcadetheme'),
        'content' => __("If enabled the slider will be hidden on mobile devices. This can improve load time and user experience on mobile devices.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),
  )
) );

// Styling Options
myarcadetheme_redux_set_section( $opt_name, array(
  'icon'      => 'el-icon-brush',
  'title'     => __('Styling Options', 'myarcadetheme'),
  'fields'    => array(
    array(
      'id'        => 'colorscheme',
      'type'      => 'select',
      'title'     => __('Theme Stylesheet (Pro)', 'myarcadetheme'),
      'subtitle'  => __('Select your themes alternative color scheme.', 'myarcadetheme'),
      'options'   => array(
        1 => __('Default', 'myarcadetheme'),
        2 => __('Dark (Pro)', 'myarcadetheme'),
        3 => __('Halloween (Pro)', 'myarcadetheme')),
      'default'   => 1,
      'desc' => __('For everything to work properly with the chosen color, off Custom CSS', 'myarcadetheme')
      ),

    array(
      'id' => 'boxed',
      'type' => 'switch',
      'title' => __('Boxed', 'myarcadetheme'),
      'subtitle'=> __('Enable this option if you want to boxed style.', 'myarcadetheme'),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
      ),

    /*array(
      'id'          => 'typography',
      'type'        => 'typography',
      'title'       => __('Typography', 'myarcadetheme' ),
      'google'      => false,
      'font-backup' => true,
      'font-style'  => false,
      'font-weight' => false,
      'text-align'  => false,
      'color'       => false,
      'output'      => array('h2.site-description'),
      'units'       =>'px',
      'subtitle'    => __('Set font family', 'myarcadetheme'),
      'default'     => array(
        'font-family' => 'Abel',
        'font-size'   => '14px',
        'line-height' => '16',
      ),
    ),*/

    array(
      'id' => 'custom_css_status',
      'type' => 'switch',
      'title' => __('Custom CSS (Pro)', 'myarcadetheme'),
      'subtitle'=> __('Enable this option if you want to activate custom css.', 'myarcadetheme'),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
      'desc' => __('Use the default style for customization', 'myarcadetheme')
      ),

    array(
      'id'        => 'body',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Body Background', 'myarcadetheme'),
      'subtitle'  => __('Choose a background (default: #F1F1F1).', 'myarcadetheme'),
      'transparent' => false,
      'default'  => '#F1F1F1',
      'required' => array('custom_css_status','equals','1'),
      ),

    array(
      'id'        => 'bght',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Background Header-Top', 'myarcadetheme'),
      'subtitle'  => __('Choose a background (default: #F8F8F8).', 'myarcadetheme'),
      'transparent' => false,
      'default'  => '#F8F8F8',
      'required' => array('custom_css_status','equals','1'),
      ),

    array(
      'id'        => 'bghct',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Header & Content', 'myarcadetheme'),
      'subtitle'  => __('Choose a background (default: #fff).', 'myarcadetheme'),
      'transparent' => false,
      'default'  => '#fff',
      'required' => array('custom_css_status','equals','1'),
      ),

    array(
      'id'        => 'bggn1',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Background General 1', 'myarcadetheme'),
      'subtitle'  => __('(default: #3469AF)', 'myarcadetheme'),
      'default'  => '#3469AF',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'bggn2',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Background General 2', 'myarcadetheme'),
      'subtitle'  => __('(default: #2D3E58)', 'myarcadetheme'),
      'default'  => '#2D3E58',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'bggn3',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Background General 3', 'myarcadetheme'),
      'subtitle'  => __('(default: #16C4BB)', 'myarcadetheme'),
      'default'  => '#16C4BB',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'bodytxtcl',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Body Text Color', 'myarcadetheme'),
      'subtitle'  => __('Choose a color (default: #666)', 'myarcadetheme'),
      'default'  => '#666',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id' => 'links',
      'type' => 'link_color',
      'compiler'  => true,
      'title' => __('Links Color', 'myarcadetheme'),
      'subtitle' => __('Pick a color for links (Default: Regular #2D3E58 / Hover #16C4BB)', 'myarcadetheme'),
      'active' => false,
      'default' => array(
        'regular' => '#2D3E58',
        'hover' => '#16C4BB',
        ),
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'frmbgr',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Forms: Regular Background Fields', 'myarcadetheme'),
      'subtitle'  => __('BACKGROUND (Default: #2D3E58)', 'myarcadetheme'),
      'default'  => '#2D3E58',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'frmbgh',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Forms: Hover Background Fields', 'myarcadetheme'),
      'subtitle'  => __('BACKGROUND (Default: #16C4BB)', 'myarcadetheme'),
      'default'  => '#16C4BB',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'frmtxtcf',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Forms: Text Color Fields', 'myarcadetheme'),
      'subtitle'  => __('Text (Default: #fff)', 'myarcadetheme'),
      'default'  => '#fff',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'frminptxtbg',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Forms: Inputs and Textareas Background', 'myarcadetheme'),
      'subtitle'  => __('BACKGROUND (Default: #fcfcfc)', 'myarcadetheme'),
      'default'  => '#fcfcfc',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'frminptxtbgtxt',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Forms: Inputs and Textareas Text Color', 'myarcadetheme'),
      'subtitle'  => __('(Default: #999)', 'myarcadetheme'),
      'default'  => '#999',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'frminptxtbgfc',
      'type'      => 'color',
      'compiler'  => true,
      'title'     => __('Forms: Inputs and Textareas Focus Background', 'myarcadetheme'),
      'subtitle'  => __('BACKGROUND (Default: #fff)', 'myarcadetheme'),
      'default'  => '#fff',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'frminptxtbgfctxt',
      'type'      => 'color',
      'compiler'    => true,
      'title'     => __('Forms: Inputs and Textareas Focus Text Color', 'myarcadetheme'),
      'subtitle'  => __('(Default: #666)', 'myarcadetheme'),
      'default'  => '#666',
      'transparent' => false,
      'required' => array('custom_css_status','equals','1')
      ),

    array(
      'id'        => 'css_custom',
      'type'      => 'ace_editor',
      'compiler'    => true,
      'title'     => __('Custom CSS', 'myarcadetheme'),
      'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', 'myarcadetheme'),
      'mode'      => 'css',
      'theme'     => 'monokai',
      'default'   => "",
      'required' => array('custom_css_status','equals','1')
    ),

    array(
      'id'        => 'toolbar-color',
      'type'      => 'color',
      'compiler'  => false,
      'title'     => __('Toolbar Color', 'myarcadetheme'),
      'subtitle'  => __('Choose the toolbar color for mobile devices.', 'myarcadetheme'),
      'transparent' => false,
      'default'  => '#3469AF',
      ),

    array(
      'id'        => 'ios-toolbar-color',
      'type'      => 'select',
      'title'     => __('IOS Status Bar Color', 'myarcadetheme'),
      'subtitle'  => __('Select the color for the IOS Status Bar.', 'myarcadetheme'),
      'options'   => array(
        'default'           => __( 'Default', 'myarcadetheme' ),
        'black'             => __( 'Black', 'myarcadetheme' ),
        'black-translucent' => __( 'Black-Translucent', 'myarcadetheme' ),
      ),
      'default'   => 'default',
      'desc'      => __( 'This will change the status bar color for IOS devices. Avoid using Black Translucent as it hampers user experience.', 'myarcadetheme' )
      ),
  )
) );

// Advertisement Banner
myarcadetheme_redux_set_section( $opt_name, array(
  'icon'      => 'el-icon-bullhorn',
  'title'     => __('Advertisement Banner', 'myarcadetheme'),
  'fields'    => array(
    array(
      'id' => 'header_banner',
      'type' => 'textarea',
      'title' => __('Header Banner', 'myarcadetheme'),
      'subtitle' => __('Put your code for 728x90 banner here.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr728.gif" alt="bnr" />',
      ),

    array(
      'id' => 'promo_banner',
      'type' => 'textarea',
      'title' => __('Friv-Style Layout Banner', 'myarcadetheme'),
      'subtitle' => __('Put your code for 300x250 banner here.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr300.gif" alt="bnr" />',
      ),

    array(
      'id' => 'vertical_box_banner',
      'type' => 'textarea',
      'title' => __('Banner content (Vertical Layout)', 'myarcadetheme'),
      'subtitle' => __('Put your code for 200x200 banner here. Only shows with Veritcal Box Design.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr200.gif" alt="bnr" />',
      ),

    array(
      'id' => 'pre_game_banner',
      'type' => 'textarea',
      'title' => __('Pre-Game Banner', 'myarcadetheme'),
      'subtitle' => __('Put your code for 200x200 banner here.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr200.gif" alt="bnr" />',
      ),

    array(
      'id' => 'game_content_banner',
      'type' => 'textarea',
      'title' => __('Game Content Banner', 'myarcadetheme'),
      'subtitle' => __('Put your code for 300x250 banner here.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr300.gif" alt="bnr" />',
      ),

    array(
      'id' => 'content_banner',
      'type' => 'textarea',
      'title' => __('Front Page Content Banner', 'myarcadetheme'),
      'subtitle' => __('Put your code for 728x90 banner here.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr728.gif" alt="bnr" />',
    ),

    array(
      'id' => 'above_game_banner',
      'type' => 'textarea',
      'title' => __('Above Game Banner', 'myarcadetheme'),
      'subtitle' => __('Put your code for 728x90 banner here.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr728.gif" alt="bnr" />',
    ),

    array(
      'id' => 'above_game_banner_margin',
      'type' => 'switch',
      'title' => __('Above Game Banner Margin', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Above Game Banner Margin", 'myarcadetheme'),
        'content' => __("Adsense Requires a 150px distance between the game and advertisement enable this option to be compliant!", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'below_game_banner',
      'type' => 'textarea',
      'title' => __('Below Game Banner', 'myarcadetheme'),
      'subtitle' => __('Put your code for 728x90 banner here.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr728.gif" alt="bnr" />',
    ),

    array(
      'id' => 'below_game_banner_margin',
      'type' => 'switch',
      'title' => __('Below Game Banner Margin', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Below Game Banner Margin", 'myarcadetheme'),
        'content' => __("Adsense Requires a 150px distance between the game and advertisement enable this option to be compliant!", 'myarcadetheme' )
      ),
      "default" => 1,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'game_preloader_ads',
      'type' => 'switch',
      'title' => __('Game Preloader Ads (Pro)', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Game Preloader Ads', 'myarcadetheme'),
        'content' => __("Enable this to display an advertisement banner before the game starts.", 'myarcadetheme' )
      ),
      "default" => 0,
      'on' => __('Enabled', 'myarcadetheme'),
      'off' => __('Disabled', 'myarcadetheme'),
    ),

    array(
      'id' => 'section_game_preloader_ads_start',
      'type' => 'section',
      'indent' => true,
      'required' => array( 'game_preloader_ads', 'equals', '1' ),
    ),

    array(
      'id'    => 'game_preloader_ads_type',
      'type'  => 'select',
      'title' => __( "Type", 'myarcadetheme' ),
      'hint' => array(
        'title' => __( "Preloader Type", 'myarcadetheme' ),
        'content' => __("Select a preloader type.", 'myarcadetheme' ),
      ),
      'options' => array(
        'default' => __( "Default", 'myarcadetheme' ),
      ),
      'default' => 'default',
    ),

    array(
      'id' => 'start_delay',
      'type' => 'spinner',
      'title' => __('Start Delay', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Start Delay', 'myarcadetheme'),
        'content' => __( 'Select the delay in milliseconds before the progress bar starts to load.', 'myarcadetheme'),
      ),
      'default' => "0",
      "min"       => "0",
      "step"      => "500",
      "max"       => "5000",
      'required' => array(
        array('game_preloader_ads', 'equals', '1' ),
        array('game_preloader_ads_type','equals','default'),
      )
    ),

    array(
      'id' => 'loading_speed',
      'type' => 'spinner',
      'title' => __('Loading Speed', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Loading Speed', 'myarcadetheme'),
        'content' => __( 'Set the loading speed of the progress bar. Low number means faster loading progress.', 'myarcadetheme'),
      ),
      'default' => "10",
      "min"       => "1",
      "step"      => "1",
      "max"       => "20",
      'required' => array(
        array('game_preloader_ads', 'equals', '1' ),
        array('game_preloader_ads_type','equals','default'),
      )
    ),

    array(
      'id' => 'loaded_text',
      'type' => 'text',
      'title' => __('Loaded Text', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Loaded Text', 'myarcadetheme'),
        'content' => __("Set a text that should be displayed below the progress bar when the game has been loaded.", 'myarcadetheme' ),
      ),
      'default' => __("Game loaded, click here to start the game!", 'myarcadetheme'),
      'required' => array(
        array('game_preloader_ads', 'equals', '1' ),
        array('game_preloader_ads_type','equals','default'),
      )
    ),

    array(
      'id' => 'loaded_text_limit',
      'type' => 'spinner',
      'title' => __('Loaded Text Appearance', 'myarcadetheme'),
      'hint' => array(
        'title' => __('Loaded Text Appearance', 'myarcadetheme'),
        'content' => __( 'Set the limit in percent of the loading progress when the "Loaded Text" should appear.', 'myarcadetheme'),
      ),
      'default' => "25",
      "min"       => "0",
      "step"      => "5",
      "max"       => "100",
      'required' => array(
        array('game_preloader_ads', 'equals', '1' ),
        array('game_preloader_ads_type','equals','default'),
      )
    ),

    array(
      'id' => 'preloader_banner',
      'type' => 'textarea',
      'title' => __('Preloader Banner', 'myarcadetheme'),
      'subtitle' => __('Put your code preloader banner code here.', 'myarcadetheme'),
      'default' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr300.png" alt="bnr" />',
      'required' => array(
        array('game_preloader_ads', 'equals', '1' ),
        array('game_preloader_ads_type','equals','default'),
      )
    ),
  )
) );

// Social Networking
myarcadetheme_redux_set_section( $opt_name, array(
  'icon'      => 'el-icon-link',
  'title'     => __( "Social Networking", 'myarcadetheme'),
  'desc'      => __( "At this section you can add your URLs for several social networking sites.", 'myarcadetheme' ),
  'fields'    => array(
    array(
      'id' => 'facebook',
      'type' => 'text',
      'title' => __('Facebook URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Facebook Page", 'myarcadetheme'),
        'content' => __("Paste your Facebook fan page URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'twitter',
      'type' => 'text',
      'title' => __('Twitter URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Twitter Page", 'myarcadetheme'),
        'content' => __("Paste your Twitter URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'linkedin',
      'type' => 'text',
      'title' => __('Linkedin URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Linkedin Company Page", 'myarcadetheme'),
        'content' => __("Paste your Linkedin Company Page URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'tumblr',
      'type' => 'text',
      'title' => __('Tumblr URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Tumblr Page", 'myarcadetheme'),
        'content' => __("Paste your Tumblr Page URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'Delicious',
      'type' => 'text',
      'title' => __('Delicious URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Our Delicious Collection", 'myarcadetheme'),
        'content' => __("Paste your Delicious Page URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'reddit',
      'type' => 'text',
      'title' => __('Reddit URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Our SubReddit", 'myarcadetheme'),
        'content' => __("Paste your Reddit Page URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'steam',
      'type' => 'text',
      'title' => __('Steam URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Our Steam Page", 'myarcadetheme'),
        'content' => __("Paste your Steam Page URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'twitch',
      'type' => 'text',
      'title' => __('Twitch URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Our Twitch Stream", 'myarcadetheme'),
        'content' => __("Paste your Twitch URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'youtube',
      'type' => 'text',
      'title' => __('Youtube URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Youtube Page", 'myarcadetheme'),
        'content' => __("Paste your Youtube URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'instagram',
      'type' => 'text',
      'title' => __('Instagram URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Instagram Page", 'myarcadetheme'),
        'content' => __("Paste your Instagram URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'pinterest',
      'type' => 'text',
      'title' => __('Pinterest URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Pinterest Page", 'myarcadetheme'),
        'content' => __("Paste your Pinterest URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'stumbleupon',
      'type' => 'text',
      'title' => __('Stumbleupon URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Stumbleupon Page", 'myarcadetheme'),
        'content' => __("Paste your Stumbleupon URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'vimeo',
      'type' => 'text',
      'title' => __('Vimeo URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Vimeo Page", 'myarcadetheme'),
        'content' => __("Paste your Vimeo URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'soundcloud',
      'type' => 'text',
      'title' => __('SoundCloud URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("SoundCloud Page", 'myarcadetheme'),
        'content' => __("Paste your SoundCloud URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'quora',
      'type' => 'text',
      'title' => __('Quora URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Quora Page", 'myarcadetheme'),
        'content' => __("Paste your Quora URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'vk',
      'type' => 'text',
      'title' => __('Vk URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Vk Page", 'myarcadetheme'),
        'content' => __("Paste your Vk URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'odnoklassniki',
      'type' => 'text',
      'title' => __('Odnoklassniki URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Odnoklassniki Page", 'myarcadetheme'),
        'content' => __("Paste your Odnoklassniki URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'renren',
      'type' => 'text',
      'title' => __('RenRen URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("RenRen Page", 'myarcadetheme'),
        'content' => __("Paste your RenRen URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'weibo',
      'type' => 'text',
      'title' => __('Weibo URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Weibo Page", 'myarcadetheme'),
        'content' => __("Paste your Weibo URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'medium',
      'type' => 'text',
      'title' => __('Medium URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Medium Blog", 'myarcadetheme'),
        'content' => __("Paste your Medium URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'telegram',
      'type' => 'text',
      'title' => __('Telegram URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Telegram Group", 'myarcadetheme'),
        'content' => __("Paste your Telegram Group URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'snapchat',
      'type' => 'text',
      'title' => __('SnapChat URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("SnapChat Page", 'myarcadetheme'),
        'content' => __("Paste your SnapChat URL here.", 'myarcadetheme' )
      ),
      'default' => '',
    ),

    array(
      'id' => 'feeds',
      'type' => 'text',
      'title' => __('Feeds URL', 'myarcadetheme'),
      'hint' => array(
        'title' => __("Feeds Page", 'myarcadetheme'),
        'content' => __("Paste your Feeds URL here.", 'myarcadetheme' )
      ),
      'default' => get_bloginfo('rss2_url'),
    ),
  )
) );

endif;