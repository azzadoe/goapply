<?php
/*
 * Shows thumbnails of the recent games
 *
 */
class WP_Widget_MABP_Recent_Games extends WP_Widget {

  // Constructor
  function __construct() {
    $widget_ops   = array('description' => __('Shows images of the most recent games.', 'myarcadetheme'));
    parent::__construct('MABP_Recent_Games', __('MyArcade Recent Games', 'myarcadetheme'), $widget_ops);
  }

  // Display Widget
  function widget($args, $instance) {
    extract($args);

    $title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', esc_attr( $instance['title'] ) );
    $limit = empty( $instance['limit'] ) ? 12 : intval( $instance['limit'] );

    global $post, $wpdb;

    echo $before_widget;

    if($title) {
      echo $before_title . $title . $after_title;
    }

    echo'<div class="most-popu"><ul class="sldr-ft">';
    // <-- START --> HERE COMES THE OUTPUT
    $games = new WP_Query("showposts=".$limit.myarcadetheme_mobile_tag().myarcadetheme_exclude_blog());

    if ( !empty($games) ) {
      while( $games->have_posts() ) : $games->the_post();
        ?>
        <!--<game>-->
        <li>
          <div class="gmcn-smal-2">
            <figure class="gm-imag">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php myarcade_thumbnail( array( 'width' => 60, 'height' => 60 , 'class' => 'widgetimage', 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option( 'lazy_load_animation' ) ) ); ?><span class="fa-gamepad"><strong><?php _e('Play', 'myarcadetheme'); ?></strong></span>
              </a>
            </figure>
            <div class="gm-titl">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php myarcade_title(20); ?></a></div>

            <?php myarcadetheme_rate_and_view(); ?>
          </div>
        </li>
        <!--</game>-->
        <?php
      endwhile;
      wp_reset_postdata();
    }

    // <-- END --> HERE COMES THE OUTPUT
    echo'</ul></div>';
    echo $after_widget;
  }

  // Update Widget
  function update($new_instance, $old_instance) {

    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['limit'] = intval($new_instance['limit']);

    return $instance;
  }

  // Display Widget Control Form
  function form($instance) {
    $instance = wp_parse_args((array) $instance, array('title' => __('Recent Games', 'myarcadetheme'), 'limit' => 12));

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );
    myarcadetheme_form_number( $this->get_field_id('limit'), $this->get_field_name('limit'), $instance['limit'] );
  }
}

/**
 * Register the widget
 *
 * @version 3.0.0
 * @since   3.0.0
 * @access  public
 * @return  void
 */
function myarcadetheme_widget_recent() {
  register_widget('WP_Widget_MABP_Recent_Games');
}
add_action( 'widgets_init', 'myarcadetheme_widget_recent' );