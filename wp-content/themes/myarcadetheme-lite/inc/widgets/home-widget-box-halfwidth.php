<?php
class Widget_MyArcadeTheme_Box_Halfwidth extends WP_Widget {

  // Constructor
  function __construct() {
    parent::__construct(
      'Widget_MyArcadeTheme_Box_Halfwidth',
      __( 'Front Page - Half Width Box', 'myarcadetheme' ),
      array(
        'description' =>  __( "Display games in a half width box.", 'myarcadetheme' )
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
    ?>
    <ul class="cntcls-n6">
    <?php
    for ( $i=1; $i <= 2; $i++ ) {
      // Generate query
      $limit = 'posts_per_page=' . intval( $instance['limit' . $i] );
      $category = ( intval( $instance['category' . $i] ) > 0 ) ? '&cat=' . intval( $instance['category' . $i] ) : '';
      $title = $instance['title' . $i];
      $category_id = intval( $instance['category' . $i] );

      // Orderby & Order
      switch ( $instance['orderby' . $i] ) {
        case 'highest_rated':
          $order  = '&r_sortby=highest_rated&r_orderby=' . $instance['order' . $i];
        break;

        case 'views':
          $order  = '&v_sortby=views&v_orderby=' . $instance['order' . $i];
        break;

        default:
          $order = '&orderby=' . $instance['orderby' . $i] . '&order=' . $instance['order' . $i];
        break;
      }

      // Generate query string
      $query_string = $limit . myarcadetheme_mobile_tag() . $order . $category;

      // Generate a query
      $the_query = new WP_Query( $query_string );
      ?>
      <li>
        <div class="blk-cn">
          <div class="titl"><a href="<?php echo get_category_link( $category_id ); ?>"><?php echo $title; ?></a> <a class="botn-mrgm fa-plus" href="<?php echo get_category_link( $category_id ); ?>"><?php _e('MORE GAMES', 'myarcadetheme'); ?></a></div>
          <ul class="lst-gmct">
            <?php
            if ( $the_query->have_posts() ) {
              while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <li>
                  <div class="gmcn-larg">
                    <figure class="gm-imag">
                      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php myarcade_thumbnail( array( 'width' => 148, 'height' => 148, 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option( 'lazy_load_animation' ) ) ); ?><span class="fa-gamepad"><?php printf( __('%sPLAY%s %sNOW!%s', 'myarcadetheme'), '<strong>', '</strong>', '<span>', '</span>'); ?></span>
                      </a>
                    </figure>

                    <div class="gm-titl">
                      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php myarcade_title(20); ?>
                      </a>
                    </div>

                    <div class="gm-desc">
                      <p><?php echo myarcade_description(120,false); ?></p>
                    </div>

                    <?php myarcadetheme_rate_and_view(); ?>
                  </div>
                </li>
                <?php
              endwhile;
              // Restore original Post Data
              wp_reset_postdata();
            }
            else {
              ?>
              <li>
                <div id="message">
                  <div class="warning"><?php _e("No games found in this category!", 'myarcadetheme' ); ?></div>
                </div>
              </li>
              <?php
            }
            ?>
          </ul>
        </div>
      </li>
      <?php
    }
    ?>
    <li class="clrmt"></li>
    </ul>
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
    for( $i = 1; $i <= 2; $i++ ) {
      $instance['title' . $i] = $new_instance['title' . $i];
      $instance['limit' . $i] = intval( $new_instance['limit' . $i] );
      $instance['order' . $i] = $new_instance['order' . $i];
      $instance['orderby' . $i] = $new_instance['orderby' . $i];
      $instance['category' . $i] = intval( $new_instance['category' . $i] );
    }
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
      'title1'     => __("Box name", 'myarcadetheme'),
      'limit1'     => 2,
      'orderby1'   => 'date',
      'order1'     => 'DESC',
      'category1'  => 0,
      'title2'     => __("Box name", 'myarcadetheme'),
      'limit2'     => 2,
      'orderby2'   => 'date',
      'order2'     => 'DESC',
      'category2'  => 0,
    ));

    for( $i = 1; $i <= 2; $i++ ) {
      echo "<h4>" . sprintf( __("Category Box %s", 'myarcadetheme' ), $i ) . "</h4>";
      myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title' . $i), $this->get_field_name('title' . $i), $instance['title' . $i] );
      myarcadetheme_form_number( $this->get_field_id('limit' . $i), $this->get_field_name('limit' . $i), $instance['limit' . $i] );
      myarcadetheme_form_category_dropdown( $this->get_field_id('category' . $i), $this->get_field_name('category' . $i), $instance['category' . $i] );
      myarcadetheme_form_dropdown_orderby( $this->get_field_id('orderby' . $i),  $this->get_field_name('orderby' . $i), $instance['orderby' . $i] );
      myarcadetheme_form_dropdown_order( $this->get_field_id('order' . $i),  $this->get_field_name('order' . $i), $instance['order' . $i] );
      if ( $i < 3 ) {
        echo "<hr />";
      }
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
function myarcadetheme_widget_box_halfwidth() {
  register_widget('Widget_MyArcadeTheme_Box_Halfwidth');
}
add_action( 'widgets_init', 'myarcadetheme_widget_box_halfwidth' );