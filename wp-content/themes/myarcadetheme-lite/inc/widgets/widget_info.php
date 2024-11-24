<?php
class WP_Widget_MABP_Info extends WP_Widget {

    // Constructor
  function __construct() {
    $widget_ops   = array('description' => __('Displays information in the footer site.', 'myarcadetheme'));
    parent::__construct('MABP_Info', __('MyArcadeTheme Info', 'myarcadetheme'), $widget_ops);
  }

    // Display Widget
  function widget($args, $instance) {
    extract($args);

    $title = isset( $instance['title']) ? apply_filters('widget_title', esc_attr($instance['title'])) : '';
    echo $before_widget.$before_title.$title.$after_title;
    ?>
    <div class="logo" itemscope itemtype="http://schema.org/Organization">
      <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name');?>" itemprop="url">
        <?php
        $logoft = myarcadetheme_get_option( 'logoft' );
        if ( ! empty( $logoft['url'] ) ) : ?>
          <img src="<?php echo $logoft['url']; ?>" alt="<?php bloginfo('blogname'); ?>" itemprop="logo">
        <?php else: ?>
          <?php bloginfo('blogname'); ?>
        <?php endif; ?>
      </a>
    </div>

    <?php echo $instance['code']; ?>
    <ul class="lst-social">
      <?php get_template_part( "partials/social", "share" ); ?>
    </ul>
    <?php
    echo $after_widget;
  }

    // Update Widget
  function update($new_instance, $old_instance) {

    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['code'] = $new_instance['code'];

    return $instance;
  }

  // Display Widget Control Form
  function form($instance) {

    $instance = wp_parse_args((array) $instance, array('title' => __('MyArcadeTheme', 'myarcadetheme'), 'code' => '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>'));

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );

    myarcadetheme_form_textarea( __('Text', 'myarcadetheme'), $this->get_field_id('code'), $this->get_field_name('code'), $instance['code'] );
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
function myarcadetheme_widget_info() {
  register_widget('WP_Widget_MABP_Info');
}
add_action( 'widgets_init', 'myarcadetheme_widget_info' );
