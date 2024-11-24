<?php
/**
 * Show random games
 */

class WP_Widget_MABP_Random_Games extends WP_Widget {

  // Constructor
  function __construct() {
    $widget_ops   = array( 'description' => __( 'Games by selectable criteria.', 'myarcadetheme' ) );
    parent::__construct( 'MABP_Random_Games', __( 'MyArcade Games', 'myarcadetheme') , $widget_ops );
  }

  // Display Widget
  function widget($args, $instance) {
    extract($args);

    $title    = apply_filters('widget_title', esc_attr( $instance['title'] ) );
    $limit    = intval( $instance['limit'] );
    $category = isset( $instance['category'] ) ? intval( $instance['category'] ) : false;
    $style    = isset( $instance['thumbnail_style'] ) ? $instance['thumbnail_style'] : 'medium';
    $type     = isset( $instance['type'] ) ? $instance['type'] : 'random';

    echo $before_widget;

    if( $title ) {
      echo $before_title . $title . $after_title;
    }

    $query_args = array( 'posts_per_page' => $limit, 'orderby' => 'rand' );

    if ( wp_is_mobile() && myarcadetheme_get_option( 'mobile' ) ) {
      $query_args['tag'] = 'mobile';
    }

    // get the blog cat
    $blog_cat = ( myarcadetheme_get_option('blogcat') ) ? intval( myarcadetheme_get_option('blogcat') ) : false;
    
    if ( $blog_cat ) {
      $query_args['category__not_in'] = array( $blog_cat );
    }

    if ( $category ) {
      $query_args['category__in'] = $category;
    }

    // Check if the category query should be overwritten
    if ( is_single() && is_game() ) {
      if ( 'related' == $type ) {
        $query_args['category__in'] = wp_get_post_categories( get_the_ID() );
      }
    }

    $games = new WP_Query( $query_args );

    if ( !empty($games) ) {
      ?>
      <ul class="widget_style_<?php echo $style; ?>">
        <?php
        while( $games->have_posts() ) : $games->the_post();
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
        ?>
      </ul>
      <?php
    }

    // <-- END --> HERE COMES THE OUTPUT

    echo $after_widget;
  }

  // Update Widget
  function update($new_instance, $old_instance) {

    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['limit'] = intval($new_instance['limit']);
    $instance['category'] = intval($new_instance['category']);
    $instance['thumbnail_style'] = $new_instance['thumbnail_style'];
    $instance['type'] = $new_instance['type'];

    return $instance;
  }

  // Display Widget Control Form
  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array(
      'title' => __('Games', 'myarcadetheme'),
      'limit' => 12,
      'category' => 0,
      'thumbnail_style' => 'medium',
      'type' => 'random',
    ) );

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );
    
    myarcadetheme_form_number( $this->get_field_id('limit'), $this->get_field_name('limit'), $instance['limit'] );

    myarcadetheme_form_select( array(
      'field_title' => __("Type", 'myarcadetheme'),
      'field_id'    => $this->get_field_id('type'),
      'field_name'  => $this->get_field_name('type'),
      'options'     => array(
        'random'    => __("Random Games", 'myarcadetheme' ),
        'related'   => __("Related Games (only on sigle view)", 'myarcadetheme' ),
      ),
      'selection'   => $instance['thumbnail_style'],
    ));

    myarcadetheme_form_category_dropdown( $this->get_field_id('category'), $this->get_field_name('category'), $instance['category'], true );
    
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
function myarcadetheme_widget_random() {
  register_widget('WP_Widget_MABP_Random_Games');
}
add_action( 'widgets_init', 'myarcadetheme_widget_random' );