<?php
/*
 * Shows an advertisement banner
 */
class WP_Widget_MABP_Advertisement extends WP_Widget {

  // Constructor
  function __construct() {
    $widget_ops   = array('description' => __('Show advertisements where ever you want in your sidebar.', 'myarcadetheme'));
    parent::__construct('MABP_Advertisement', __('MyArcade Advertisement', 'myarcadetheme'), $widget_ops);
  }

  // Display Widget
  function widget($args, $instance) {
    extract($args);

    $title = apply_filters('widget_title', esc_attr($instance['title']));
    $adcode = $instance['adcode'];
    ?>
    <!--<advmnt>-->
    <div class="bnr">
      <?php echo $adcode; ?>
    </div>
    <!--</advmnt>-->
    <?php
  }

  // Update Widget
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['adcode'] = $new_instance['adcode'];

    return $instance;
  }

  // Display Widget Control Form
  function form($instance) {
    $instance = wp_parse_args((array) $instance, array('title' => __('Advertisement', 'myarcadetheme'), 'adcode' => ''));

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );

    myarcadetheme_form_textarea( __('300x250px Banner Code', 'myarcadetheme'), $this->get_field_id('adcode'), $this->get_field_name('adcode'), $instance['adcode'] );
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
function myarcadetheme_widget_advertisement() {
  register_widget('WP_Widget_MABP_Advertisement');
}
add_action( 'widgets_init', 'myarcadetheme_widget_advertisement' );