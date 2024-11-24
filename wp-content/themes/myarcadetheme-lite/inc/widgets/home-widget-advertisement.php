<?php
class Widget_MyArcadeTheme_HomeAds extends WP_Widget {

  // Constructor
  function __construct() {
    parent::__construct(
      'Widget_MyArcadeTheme_HomeAds',
      __( 'Front Page - Advertisements', 'myarcadetheme' ),
      array(
        'description' => __( 'Display an advertisement banner (728x90px).', 'myarcadetheme' )
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
    if ( ! empty($instance['code'] ) ) : ?>
    <div class="bnr728">
      <?php echo $instance['code']; ?>
    </div>
    <?php
    endif;
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
    $instance['code'] = $new_instance['code'];

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
      'code' => '<img src="'.get_template_directory_uri().'/images/cnt/bnr728.gif" alt="bnr" />'
    ));

    myarcadetheme_form_textarea( __("Banner Code", 'myarcadetheme'), $this->get_field_id('code'), $this->get_field_name('code'), $instance['code'] );
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
function myarcadetheme_widget_home_ads() {
  register_widget('Widget_MyArcadeTheme_HomeAds');
}
add_action( 'widgets_init', 'myarcadetheme_widget_home_ads' );