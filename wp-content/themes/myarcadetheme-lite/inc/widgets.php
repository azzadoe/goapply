<?php
// Include Widgets
$myarcadetheme_widgets = array(
  /* Sidebar Widgets */
  'widget_most_played',
  'widget_most_rated',
  'widget_user_panel',
  'widget_youtube_video',
  'widget_ads125',
  'widget_recent_games',
  'widget_random_games',
  'widget_advertisement',
  'widget_info',
  'widget_most_popular',
  'widget_recent_posts',
  /* Home Widgets */
  'home-widget-text',
  'home-widget-advertisement',
  'home-widget-halloffame',
  'home-widget-box-horizontal',
  'home-widget-box-fullwidth',
  'home-widget-box-vertical',
  'home-widget-box-halfwidth',
  'home-widget-carousel',
);

foreach( $myarcadetheme_widgets as $widget ) {
  locate_template ('inc/widgets/' . $widget . '.php', true, true);
}

/**
 * Create sidebars
 *
 * @version 3.0.0
 * @since   1.0.0
 * @access  public
 * @return  void
 */
function myarcadetheme_widgets_init() {

  register_sidebar(
    array(
      'name'          => __('Front Page Builder (Pro)', 'myarcadetheme'),
      'id'            =>'frontpage-sidebar',
      'description'   => __('This is where you can build your front page. Enable the builder at Theme Options -> Front Page -> Design -> Front Page Builder.', 'myarcadetheme'),
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '',
      'after_title'   => '',
    )
  );


  register_sidebar(
    array(
      'name'          => __('Main Sidebar', 'myarcadetheme'),
      'id'            =>'others-sidebar',
      'description'   => __('This is the sidebar that gets shown on the home page.', 'myarcadetheme'),
      'before_widget' => '<div id="%1$s" class="blk-cn %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="titl">',
      'after_title'   => '</div>',
    )
  );

  register_sidebar(
    array(
      'name'          => __('Single Sidebar', 'myarcadetheme'),
      'id'            =>'single-sidebar',
      'description'   => __('This is your sidebar that gets shown on the game or blog pages.', 'myarcadetheme'),
      'before_widget' => '<div id="%1$s" class="blk-cn %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="titl">',
      'after_title'   => '</div>',
    )
  );

  register_sidebar(
    array(
      'name'          => __('Game Left Sidebar (Pro)', 'myarcadetheme'),
      'id'            => 'game-left-sidebar',
      'description'   => __('This is your sidebar that gets shown on the left site next to the game.', 'myarcadetheme'),
      'before_widget' => '<div id="%1$s" class="blk-cn %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="titl">',
      'after_title'   => '</div>',
    )
  );

  register_sidebar(
    array(
      'name'          => __('Game Right Sidebar (Pro)', 'myarcadetheme'),
      'id'            => 'game-right-sidebar',
      'description'   => __('This is your sidebar that gets shown on the right site next to the game.', 'myarcadetheme'),
      'before_widget' => '<div id="%1$s" class="blk-cn %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="titl">',
      'after_title'   => '</div>',
    )
  );

  register_sidebar(
    array(
      'name'          => __('Page Sidebar', 'myarcadetheme'),
      'id'            =>'page-sidebar',
      'description'   => __('This is your sidebar that gets shown on most of your pages.', 'myarcadetheme'),
      'before_widget' => '<div id="%1$s" class="blk-cn %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="titl">',
      'after_title'   => '</div>',
    )
  );

  register_sidebar(
    array('name'          => __('Category Sidebar', 'myarcadetheme'),
        'id'            =>'category-sidebar',
        'description'   => __('This is your sidebar that gets shown on the category pages.', 'myarcadetheme'),
        'before_widget' => '<div id="%1$s" class="blk-cn %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="titl">',
        'after_title'   => '</div>',
    )
  );

  register_sidebar(
    array('name'          => __('Footer Sidebar', 'myarcadetheme'),
        'id'            =>'footer-sidebar',
        'description'   => __('This is your sidebar that gets shown on the footer.', 'myarcadetheme'),
        'before_widget' => '<div id="%1$s" class="blk-cn ftblk cols-n3 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="titl">',
        'after_title'   => '</div>',
    )
  );
}
add_action('widgets_init', 'myarcadetheme_widgets_init');