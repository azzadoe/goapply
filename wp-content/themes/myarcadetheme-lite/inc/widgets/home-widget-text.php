<?php
class Widget_MyArcadeTheme_HomeText extends WP_Widget {

  // Constructor
  function __construct() {
    parent::__construct(
      'Widget_MyArcadeTheme_HomeText',
      __( 'Front Page - Text Box', 'myarcadetheme' ),
      array(
        'description' => __( 'Add some text for SEO purpose or just to introduce your site.', 'myarcadetheme' )
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
    <div id="front_page_text" class="blk-cn">
      <?php if ( ! empty($instance) ) : ?>
      <div class="titl"><?php echo $instance['title']; ?></div>
      <?php endif; ?>
      <span><?php echo $instance['content']; ?></span>
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
    $instance['content'] = $new_instance['content'];

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

    $instance = wp_parse_args( (array) $instance, array( 'title' => __('Front Page Text', 'myarcadetheme' ), 'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' ) );

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );

    myarcadetheme_form_textarea( __("Text", 'myarcadetheme'), $this->get_field_id('content'), $this->get_field_name('content'), $instance['content'] );
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
function myarcadetheme_widget_home_text() {
  register_widget('Widget_MyArcadeTheme_HomeText');
}
add_action( 'widgets_init', 'myarcadetheme_widget_home_text' );