<?php
/*
 * Embeds a youtube video
 */
class WP_Widget_MABP_Youtube_Video extends WP_Widget {

    // Constructor
  function __construct() {
    $widget_ops   = array('description' => __('Embeds a youtube video to your sidebar.', 'myarcadetheme'));
    parent::__construct( 'MABP_Youtube_Video', __('MyArcade Youtube Widget', 'myarcadetheme'), $widget_ops );
  }

    // Display Widget
  function widget($args, $instance) {
    extract($args);

    $title   = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', esc_attr( $instance['title'] ) );
    $videoid = empty( $instance['videoid'] ) ? 'eBx9mYEmPyQ' : esc_attr( $instance['videoid'] );

    echo $before_widget;

    if($title) {
      echo $before_title . $title . $after_title;
    }
      // <-- START --> HERE COMES THE OUPUT

    ?>
    <div class="videowidget">
      <object width="300" height="250">
        <param name="movie" value="https://www.youtube.com/v/<?php echo $videoid; ?>&hl=en&fs=1&rel=0&border=1"></param>
        <param name="allowFullScreen" value="true"></param>
        <param name="allowscriptaccess" value="always"></param>
        <embed src="https://www.youtube.com/v/<?php echo $videoid; ?>&hl=en&fs=1&rel=0&border=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="300" height="250"></embed>
      </object>
    </div>
    <?php

      // <-- END --> HERE COMES THE OUPUT
    echo $after_widget;
  }

    // Update Widget
  function update($new_instance, $old_instance) {

    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['videoid'] = strip_tags($new_instance['videoid']);

    return $instance;
  }

  // Display Widget Control Form
  function form($instance) {
    $instance = wp_parse_args((array) $instance, array('title' => __('Featured Video', 'myarcadetheme'), 'videoid' => 'eBx9mYEmPyQ'));

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );
    myarcadetheme_form_text( __("Video ID", 'myarcadetheme'), $this->get_field_id('videoid'), $this->get_field_name('videoid'), $instance['videoid'] );
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
function myarcadetheme_widget_youtube() {
  register_widget('WP_Widget_MABP_Youtube_Video');
}
add_action( 'widgets_init', 'myarcadetheme_widget_youtube' );