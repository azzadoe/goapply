<?php
class Widget_MyArcadeTheme_Box_Horizontal extends WP_Widget {

  // Constructor
  function __construct() {
    parent::__construct(
      'Widget_MyArcadeTheme_Box_Horizontal',
      __( 'Front Page - Horizontal Box', 'myarcadetheme' ),
      array(
        'description' =>  __( "Display games in a horizontal box.", 'myarcadetheme' )
      )
    );
  }

  /**
   * Display the widget
   *
   * @version 3.0.0
   * @since   3.0.0
   * @access  public
   * @param   array $args
   * @param   array $instance
   * @return  void
   */
  function widget( $args, $instance ) {

    // Generate query
    $limit = 'posts_per_page=' . intval( $instance['limit'] );
    $category = ( intval( $instance['category'] ) > 0 ) ? '&cat=' . intval( $instance['category'] ) : '';

    // Orderby & Order
    switch ( $instance['orderby'] ) {
      case 'highest_rated':
        $order  = '&r_sortby=highest_rated&r_orderby=' . $instance['order'];
      break;

      case 'views':
        $order  = '&v_sortby=views&v_orderby=' . $instance['order'];
      break;

      default:
        $order = '&orderby=' . $instance['orderby'] . '&order=' . $instance['order'];
      break;
    }

    // Generate query string
    $query_string = $limit . myarcadetheme_mobile_tag() . $order . $category;

    // Generate a query
    $the_query = new WP_Query( $query_string );

    ?>
    <div class="blk-cn">
      <div class="titl">
        <a href="<?php echo get_category_link( $instance['category'] ); ?>">
          <?php echo $instance['title']; ?></a> <a class="botn-mrgm fa-plus" href="<?php echo get_category_link( $instance['category'] ); ?>"><?php _e( 'MORE GAMES', 'myarcadetheme'); ?>
        </a>
      </div>
      <?php
      if ( $the_query->have_posts() ) {
        ?>
        <ul class="lst-gams">
          <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
          <li>
            <div class="gmcn-midl">
              <figure class="gm-imag">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                  <?php myarcade_thumbnail( array( 'width' => 148, 'height' => 148, 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option( 'lazy_load_animation' ) ) ); ?>
                </a>
              </figure>
              <div class="gm-text">
                <div class="gm-cate"><?php echo myarcade_category(); ?></div>

                <div class="gm-titl">
                  <a href="<?php the_permalink(); ?>">
                    <?php myarcade_title(15); ?>
                  </a>
                </div>

                <?php myarcadetheme_rate_and_view(); ?>
              </div>
            </div>
          </li>
          <?php endwhile; ?>
        </ul>
        <?php
        // Restore original Post Data
        wp_reset_postdata();
      }
      else {
        ?>
        <div id="message">
          <div class="warning"><?php _e("No games found in this category!", 'myarcadetheme' ); ?></div>
        </div>
        <?php
      }
      ?>
    </div>
    <?php
  }

 /**
   * Update Widget settings
   *
   * @version 3.0.0
   * @since   3.0.0
   * @access  public
   * @param   array $new_instance
   * @param   array $old_instance
   * @return  array
   */
  function update( $new_instance, $old_instance ) {

    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['limit'] = intval( $new_instance['limit'] );
    $instance['order'] = $new_instance['order'];
    $instance['orderby'] = $new_instance['orderby'];
    $instance['category'] = intval( $new_instance['category'] );
    return $instance;
  }

  /**
   * Display widget settings
   *
   * @version 3.0.0
   * @since   3.0.0
   * @access  public
   * @param   array $instance
   * @return  void
   */
  function form( $instance ) {

    $instance = wp_parse_args( (array) $instance, array(
      'title'     => __("Box name", 'myarcadetheme'),
      'limit'     => 5,
      'orderby'   => 'date',
      'order'     => 'DESC',
      'category'  => 0,
    ));

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );

    myarcadetheme_form_number( $this->get_field_id('limit'), $this->get_field_name('limit'), $instance['limit'] );

    myarcadetheme_form_category_dropdown( $this->get_field_id('category'), $this->get_field_name('category'), $instance['category'] );

    myarcadetheme_form_dropdown_orderby( $this->get_field_id('orderby'),  $this->get_field_name('orderby'), $instance['orderby'] );

    myarcadetheme_form_dropdown_order( $this->get_field_id('order'),  $this->get_field_name('order'), $instance['order'] );
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
function myarcadetheme_widget_box_horizontal() {
  register_widget('Widget_MyArcadeTheme_Box_Horizontal');
}
add_action( 'widgets_init', 'myarcadetheme_widget_box_horizontal' );