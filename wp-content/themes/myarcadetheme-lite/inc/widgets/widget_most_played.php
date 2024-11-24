<?php
/*
 * Shows thumbnails of the most played games
 *
 * Required: WP-PostViews Plugin
 *
 * @package MyArcadeTheme/Widgets
 */

class WP_Widget_MABP_Most_Played extends WP_Widget {

  // Constructor
  function __construct() {
		$widget_ops = array(
			'description' => __('Shows images of the most played games. WP-PostViews Plugin required!', 'myarcadetheme'),
		);

    parent::__construct('MABP_Most_Played', __('MyArcade Most Played Games', 'myarcadetheme'), $widget_ops);
  }

	// Display Widget.
  function widget($args, $instance) {
    extract($args);

		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', esc_attr($instance['title'] ) );
		$limit = empty( $instance['limit'] ) ? 12 : intval( $instance['limit'] );
    $style = isset($instance['thumbnail_style']) ? $instance['thumbnail_style'] : 'medium';

    echo $before_widget;

    if($title) {
      echo $before_title . $title . $after_title;
    }

    $query_args = array( 'posts_per_page' => $limit );

    if ( wp_is_mobile() && myarcadetheme_get_option( 'mobile' ) ) {
      $query_args['tag'] = 'mobile';
    }

		// Get the blog cat.
    $blog_cat = ( myarcadetheme_get_option('blogcat') ) ? intval( myarcadetheme_get_option('blogcat') ) : false;

    if ( $blog_cat ) {
      $query_args['category__not_in'] = array( $blog_cat );
    }

    if ( function_exists( 'the_views' ) ) {
      $query_args['v_sortby'] = 'views';
      $query_args['v_orderby'] = 'desc';
		} else {
      $query_args['orderby'] = 'rand';
    }

    $games = new WP_Query( $query_args );
    ?>
    <ul class="widget_style_<?php echo $style; ?>">
    <?php
    if ( !empty($games) ) {

			while ( $games->have_posts() ) :
				$games->the_post();
        ?>
        <!--<game>-->
        <li>
          <div class="gmcn-smal-3">
              <figure class="gm-imag">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                  <?php myarcade_thumbnail( array( 'width' => 60, 'height' => 60 , 'class' => 'widgetimage', 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option( 'lazy_load_animation' ) ) ); ?>
                  <?php if ( 'medium' == $style ) : ?>
                  <span class="fa-gamepad"><strong><?php _e('Play', 'myarcadetheme'); ?></strong></span>
                  <?php endif; ?>
                </a>
              </figure>
              <?php if ( 'small' == $style ) : ?>
              <div class="gm-titl"><a href="<?php the_permalink(); ?>"><?php myarcade_title(20); ?></a></div>
              <?php endif; ?>
          </div>
        </li>
        <!--</game>-->
        <?php
      endwhile;
      wp_reset_postdata();
    }

    echo'</ul>';
    echo $after_widget;
  }

	/**
	 * Update Widget.
	 *
	 * @public
	 * @param  array $new_instance Instance data.
	 * @param  array $old_instance Instance data.
	 * @return array               Array of instance data.
	 */
  function update($new_instance, $old_instance) {

    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['limit'] = intval($new_instance['limit']);
    $instance['thumbnail_style'] = $new_instance['thumbnail_style'];

    return $instance;
  }

	/**
	 * Display Widget Control Form.
	 */
  function form($instance) {
    global $wpdb;

    $instance = wp_parse_args( (array) $instance, array(
      'title' => __('Most Played Games', 'myarcadetheme'),
      'limit' => 12,
      'thumbnail_style' => 'medium'
    ));

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );

    myarcadetheme_form_number( $this->get_field_id('limit'), $this->get_field_name('limit'), $instance['limit'] );

    myarcadetheme_form_select( array(
      'field_title' => __("Thumbnail Style", 'myarcadetheme'),
      'field_id' => $this->get_field_id('thumbnail_style'),
      'field_name' => $this->get_field_name('thumbnail_style'),
      'options' => array(
        'small'    => __("Small", 'myarcadetheme' ),
        'medium'  => __("Medium", 'myarcadetheme' ),
      ),
      'selection' => $instance['thumbnail_style'],
    ));
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
function myarcadetheme_widget_most_played() {
  register_widget('WP_Widget_MABP_Most_Played');
}
add_action( 'widgets_init', 'myarcadetheme_widget_most_played' );
