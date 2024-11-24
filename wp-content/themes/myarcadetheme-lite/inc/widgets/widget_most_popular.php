<?php
/*
 * Shows thumbnails of the most popular games
 *
 * Required: WP-PostViews Plugin
 */

if ( !class_exists('WP_Widget_MABP_Most_Popular') ) {
  class WP_Widget_MABP_Most_Popular extends WP_Widget {

    // Constructor
    function __construct() {
      $widget_ops   = array('description' => __('Shows images of the most played games. WP-PostViews Plugin required!', 'myarcadetheme'));
      parent::__construct('MABP_Most_Popular', __('MyArcade Most Popular Games', 'myarcadetheme'), $widget_ops);
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

      $query_args = array( 'posts_per_page' => $limit );

      if ( wp_is_mobile() && myarcadetheme_get_option( 'mobile' ) ) {
        $query_args['tag'] = 'mobile';
      }

      // get the blog cat
      $blog_cat = ( myarcadetheme_get_option('blogcat') ) ? intval( myarcadetheme_get_option('blogcat') ) : false;
      if ( $blog_cat ) {
        $query_args['category__not_in'] = array( $blog_cat );
      }

      // <-- START --> HERE COMES THE OUTPUT
      if ( function_exists( 'the_views' ) ) {
        $query_args['v_sortby'] = 'views';
        $query_args['v_orderby'] = 'desc';
      }
      else {
        $query_args['orderby'] = 'rand';
      }

      $games = new WP_Query( $query_args );

      echo'<div class="most-popu"><ul class="sldr-ft">';

      if ( !empty($games) ) {

        while( $games->have_posts() ) : $games->the_post();
        ?>
        <!--<game>-->
        <li>
          <div class="gmcn-smal-2">
            <figure class="gm-imag">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php myarcade_thumbnail( array( 'width' => 60, 'height' => 60 , 'class' => 'widgetimage', 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option( 'lazy_load_animation' ) ) ); ?><span class="fa-gamepad"><?php printf( __('%sPLAY%s %sNOW!%s', 'myarcadetheme'), '<strong>', '</strong>', '<span>', '</span>'); ?></span>
              </a>
            </figure>
            <div class="gm-titl"><a href="<?php the_permalink(); ?>"><?php myarcade_title(20); ?></a></div>

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
      $instance = wp_parse_args((array) $instance, array('title' => __('MOST POPULAR', 'myarcadetheme'), 'limit' => 6));

      myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );

      myarcadetheme_form_number( $this->get_field_id('limit'), $this->get_field_name('limit'), $instance['limit'] );
    }
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
function myarcadetheme_widget_most_popular() {
  register_widget('WP_Widget_MABP_Most_Popular');
}
add_action( 'widgets_init', 'myarcadetheme_widget_most_popular' );
