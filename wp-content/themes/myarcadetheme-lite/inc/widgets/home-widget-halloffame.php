<?php
class Widget_MyArcadeTheme_HallOfFame extends WP_Widget {

  // Constructor
  function __construct() {
    parent::__construct(
      'Widget_MyArcadeTheme_HallOfFame',
      __( 'Front Page - Hall Of Fame', 'myarcadetheme' ),
      array(
        'description' =>  __( "Show the best players of your site (MyScoresPresenter required).", 'myarcadetheme' )
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
    if ( defined('MYSCORE_VERSION') ) {
      // Get x best players
      $players = myarcadetheme_get_best_players(5);
      ?>
      <div id="hall_of_fame" class="blk-cn">
        <?php if ( ! empty( $instance['title'] ) ) : ?>
        <div class="titl"><?php echo $instance['title']; ?></div>
        <?php endif; ?>

        <?php if ( $players ) : ?>
        <ul>
          <?php
          foreach ($players as $player) {
            ?>
            <li>
              <div class="avatar"><?php echo get_avatar($player->user_id, 90); ?></div>
              <div class="name"><?php echo myscore_get_user_link($player->user_id); ?></div>
              <div class="plays"><?php printf( __( "%s plays", 'myarcadetheme' ), myarcade_format_number( $player->plays ) ); ?></div>
              <div class="highscores"><?php printf( __( "%s High Scores", 'myarcadetheme' ), myarcade_format_number( $player->highscores ) ); ?></div>
            </li>
            <?php
          }
          ?>
        </ul>
        <?php else : ?>
        <p><?php _e( "Currently there are no best players!", 'myarcadetheme' ); ?></p>
        <?php endif; ?>
      </div>
      <?php
    }
    else {
      ?>
      <div id="message">
        <div class="warning"><?php _e("MyScoresPresenter is required in order to dispaly 'Hall of Fame'.", 'myarcadetheme' ); ?></div>
      </div>
      <?php
    }
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
    $instance = wp_parse_args( (array) $instance, array( 'title' => __('Hall Of Fame', 'myarcadetheme' ) ) );

    myarcadetheme_form_text( __("Title", 'myarcadetheme'), $this->get_field_id('title'), $this->get_field_name('title'), $instance['title'] );
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
function myarcadetheme_widget_halloffame() {
  register_widget('Widget_MyArcadeTheme_HallOfFame');
}
add_action( 'widgets_init', 'myarcadetheme_widget_halloffame' );