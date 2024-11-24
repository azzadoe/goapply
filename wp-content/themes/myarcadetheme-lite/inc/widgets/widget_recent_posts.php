<?php
/*
 * Shows thumbnails of the recent games
 *
 */
class WP_Widget_MABP_Recent_Posts extends WP_Widget {

  // Constructor
  function __construct() {
    $widget_ops   = array('description' => __('Shows most recent blog posts with thumbnails.', 'myarcadetheme'));
    parent::__construct('MABP_Recent_Posts', __('MyArcade Recent Posts', 'myarcadetheme'), $widget_ops);
  }

  // Display Widget
  function widget($args, $instance) {
    extract($args);

    $title = apply_filters('widget_title', esc_attr($instance['title']));
    $limit = intval($instance['limit']);

    global $post, $wpdb;

    echo $before_widget;

    if($title) {
      echo $before_title . $title . $after_title;
    }

    echo'<div class="most-popu"><ul class="sldr-ft">';
    // <-- START --> HERE COMES THE OUTPUT
    $args = array(
      'category__in' => wp_get_post_categories( get_the_ID() ),
      'posts_per_page' => $limit,
    );

    $posts = new WP_Query( $args );

    if ( !empty($posts) ) {
      while( $posts->have_posts() ) : $posts->the_post();
        ?>
        <!--<game>-->
        <li>
          <div class="gmcn-smal-2">
            <figure class="gm-imag">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php myarcade_thumbnail( array( 'width' => 60, 'height' => 60 , 'class' => 'widgetimage', 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option( 'lazy_load_animation' ) ) ); ?><span class="fa-eye"><strong><?php _e('Read More', 'myarcadetheme'); ?></strong></span>
              </a>
            </figure>
            <div class="gm-titl">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php myarcade_title(20); ?></a></div>

              <?php myarcade_excerpt(20); ?>
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
    $instance = wp_parse_args((array) $instance, array('title' => __('Recent Posts', 'myarcadetheme'), 'limit' => 12));

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
function myarcadetheme_widget_recent_posts() {
  register_widget('WP_Widget_MABP_Recent_Posts');
}
add_action( 'widgets_init', 'myarcadetheme_widget_recent_posts' );