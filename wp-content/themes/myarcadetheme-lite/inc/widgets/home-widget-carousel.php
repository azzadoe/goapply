<?php
class Widget_MyArcadeTheme_Carousel extends WP_Widget {

  // Constructor
  function __construct() {
    parent::__construct(
      'Widget_MyArcadeTheme_Carousel',
      __( 'Front Page - Carousel', 'myarcadetheme' ),
      array(
        'description' =>  __( "Shows a games carousel.", 'myarcadetheme' )
      )
    );
  }

  /**
   * Display the widget
   *
   * @version 4.2.0
   * @since   4.2.0
   * @access  public
   * @param   array $args
   * @param   array $instance
   * @return  void
   */
  function widget( $args, $instance ) {
    extract($args);

    $title = apply_filters('widget_title', esc_attr($instance['title']));
    $limit = intval($instance['limit']);
    $category = isset($instance['category']) ? intval($instance['category']) : false;

    $query_args = array( 'posts_per_page' => $limit );

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

    $games = new WP_Query( $query_args );
    ?>
    <div id="<?php $args['widget_id'] ?>" class="blk-cn home_carousel">
      <div class="titl"><?php echo $title; ?></div>
        <?php if ( $games ) : ?>
        <ul class="lst-gams">
          <?php while( $games->have_posts() ) : $games->the_post(); ?>
          <li>
            <div class="gmcn-midl">
              <figure class="gm-imag">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                  <?php myarcade_thumbnail( array( 'width' => 148, 'height' => 148, 'lazy_load' => false ) ); ?>
                </a>
              </figure>
              <div class="gm-text">
                <div class="gm-titl">
                  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_title(); ?>
                  </a>
                </div>
              </div>
            </div>
          </li>
          <?php endwhile;
          // Restore original Post Data
          wp_reset_postdata();
          ?>
        </ul>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function($){
      $('.home_carousel ul').bxSlider({auto:true,autoHover:true,moveSlides:1,slideWidth:168,minSlides:2,maxSlides:5,infiniteLoop:true,pager:false});
    });
    </script>
    <?php
  }

 /**
   * Update Widget settings
   *
   * @version 4.2.0
   * @since   4.2.0
   * @access  public
   * @param   array $new_instance
   * @param   array $old_instance
   * @return  array
   */
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['limit'] = intval($new_instance['limit']);
    $instance['category'] = intval($new_instance['category']);

    return $instance;
  }

  /**
   * Display widget settings
   *
   * @version 4.2.0
   * @since   4.2.0
   * @access  public
   * @param   array $instance
   * @return  void
   */
  function form( $instance ) {
    $instance = wp_parse_args((array) $instance, array('title' => __('RECOMMENDED GAMES', 'myarcadetheme'), 'limit' => 10, 'category' => 0));

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );

    myarcadetheme_form_number( $this->get_field_id('limit'), $this->get_field_name('limit'), $instance['limit'] );

    myarcadetheme_form_category_dropdown( $this->get_field_id('category'), $this->get_field_name('category'), $instance['category'], true );
  }
}

/**
 * Register the widget
 *
 * @version 4.2.0
 * @since   4.2.0
 * @access  public
 * @return  void
 */
function myarcadetheme_home_widget_carousel() {
  register_widget('Widget_MyArcadeTheme_Carousel');
}
add_action( 'widgets_init', 'myarcadetheme_home_widget_carousel' );