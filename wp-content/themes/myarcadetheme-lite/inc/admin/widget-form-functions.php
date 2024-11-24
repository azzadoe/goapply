<?php
/**
 * Functions used to generate widget form fields
 */

/**
 * Order parameters in widgets
 *
 * @version 3.0.0
 * @since   3.0.0
 * @access  public
 * @param   string $field_id
 * @param   string $field_name
 * @param   string $selection
 * @return  void
 */
function myarcadetheme_form_dropdown_order( $field_id = '', $field_name = '', $selection = '' ) {
  ?>
  <p>
  <label for="<?php echo $field_id; ?>"><?php _e('Order', 'myarcadetheme'); ?></label><br />
  <select name="<?php echo $field_name; ?>" id="<?php echo $field_id; ?>" class="widefat">
    <option value="ASC" <?php selected($selection, 'ASC'); ?>><?php _e("Ascending", 'myarcadetheme') ?></option>
    <option value="DESC" <?php selected($selection, 'DESC'); ?>><?php _e("Descending", 'myarcadetheme') ?></option>
  </select>
  </p>
  <?php
}

/**
 * Order by parameters in widgets
 *
 * @version 3.0.0
 * @since   3.0.0
 * @access  public
 * @param   string $field_id
 * @param   string $field_name
 * @param   string $selection
 * @return  void
 */
function myarcadetheme_form_dropdown_orderby( $field_id = '', $field_name = '', $selection = '' ) {
  ?>
  <p>
  <label for="<?php echo $field_id; ?>"><?php _e('Order by', 'myarcadetheme'); ?></label><br />
  <select name="<?php echo $field_name; ?>" id="<?php echo $field_id; ?>" class="widefat">
    <option value="name" <?php selected($selection, 'name'); ?>><?php _e("Name", 'myarcadetheme'); ?></option>
    <option value="date" <?php selected($selection, 'date'); ?>><?php _e("Date", 'myarcadetheme'); ?></option>
    <option value="rand" <?php selected($selection, 'rand'); ?>><?php _e("Random", 'myarcadetheme'); ?></option>
    <option value="comment_count" <?php selected($selection, 'comment_count'); ?>><?php _e("Comment count", 'myarcadetheme'); ?></option>
    <option value="highest_rated" <?php selected($selection, 'highest_rated'); ?>><?php _e("Best Rated", 'myarcadetheme'); ?></option>
    <option value="views" <?php selected($selection, 'views'); ?>><?php _e("Most Played", 'myarcadetheme'); ?></option>
  </select>
  </p>
  <?php
}

/**
 * Numeric field
 *
 * @version 3.0.0
 * @since   3.0.0
 * @access  public
 * @param   string $field_id
 * @param   string $field_name
 * @param   string $value
 * @return  void
 */
function myarcadetheme_form_number( $field_id = '', $field_name = '', $value = '' ) {
  ?>
  <p>
  <label for="<?php echo $field_id; ?>"><?php _e('Number of games:', 'myarcadetheme'); ?></label>
  <input id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>" type="number" class="widefat" value="<?php echo intval( $value ); ?>" />
  </p>
  <?php
}

/**
 * Text field
 *
 * @version 3.0.0
 * @since   3.0.0
 * @access  public
 * @param   string $field_id
 * @param   string $field_name
 * @param   string $value
 * @return  void
 */
function myarcadetheme_form_text( $field_title = '', $field_id = '', $field_name = '', $value = '' ) {
  ?>
  <p>
  <label for="<?php echo $field_id; ?>"><?php echo $field_title; ?></label>
  <input id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>" class="widefat" type="text" value="<?php echo $value; ?>" />
  </p>
  <?php
}

/**
 * Text area
 *
 * @version 3.0.0
 * @since   3.0.0
 * @access  public
 * @param   string $field_id
 * @param   string $field_name
 * @param   string $value
 * @return  void
 */
function myarcadetheme_form_textarea( $field_title = '', $field_id = '', $field_name = '', $value = '' ) {
  ?>
  <p>
  <label for="<?php echo $field_id; ?>"><?php echo $field_title; ?></label>
  <textarea id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>" class="widefat"><?php echo $value; ?></textarea>
  </p>
  <?php
}

/**
 * Single category selection
 *
 * @version 3.0.0
 * @since   3.0.0
 * @access  public
 * @param   string $field_id
 * @param   string $field_name
 * @param   string $selection
 * @return  void
 */
function myarcadetheme_form_category_dropdown( $field_id = '', $field_name = '', $selection = '', $show_all = false ) {
  $args = array(
    'orderby'     => 'NAME',
    'hide_empty'  => false,
    'name'        => $field_name,
    'id'          => $field_id,
    'selected'    => $selection,
    'class'       => 'widefat',
  );

  if ( true == $show_all ) {
    $args['option_none_value'] = '0';
    $args['show_option_none'] = __("All categories", 'myarcadetheme');
  }
  ?>
  <p>
  <label for="<?php echo $field_id; ?>"><?php _e('Category', 'myarcadetheme'); ?></label><br />
  <?php wp_dropdown_categories( $args ); ?>
  </p>
  <?php
}

/**
 * Single category selection
 *
 * @version 3.0.0
 * @since   3.0.0
 * @access  public
 * @param   string $field_id
 * @param   string $field_name
 * @param   string $selection
 * @return  void
 */
function myarcadetheme_form_category_multi( $field_id = '', $field_name = '', $selection = '' ) {
  $categories = get_categories('hide_empty=0');
  $categories_array = array();

  $selected_ids = explode( ',' , $selection ) ;

  foreach ( $categories as $category ) {
    $categories_array[ $category->cat_ID ] = $category->cat_name;
  }
  ?>
  <p>
  <label for="<?php echo $field_id; ?>"><?php _e('Categories', 'myarcadetheme'); ?></label><br />
  <select name="<?php echo $field_name; ?>[]" multiple="multiple">
    <?php foreach ( $categories_array as $id => $name ) : ?>
    <option value="<?php echo $id;?>" <?php if ( empty( $selected_ids ) || in_array( $id , $selected_ids ) ) { echo 'selected="selected"'; } ?>><?php echo $name; ?></option>
    <?php endforeach; ?>
    </select>
  </p>
  <?php
}

/**
 * Select
 *
 * @version 3.1.0
 * @since   3.1.0
 * @access  public
 * @param   string $field_id
 * @param   string $field_name
 * @param   string $selection
 * @return  void
 */
function myarcadetheme_form_select( $args = array() ) {

  $defaults = array(
    'field_title' => '',
    'field_id' => '',
    'field_name' => '',
    'options' => array(),
    'selection' => '',
  );

  $r = wp_parse_args( $args, $defaults );
  extract($r);
  ?>
  <p>
  <label for="<?php echo $field_id; ?>"><?php echo $field_title; ?></label><br />
  <select name="<?php echo $field_name; ?>" class="widefat">
    <?php foreach ( $options as $id => $name ) : ?>
    <option value="<?php echo $id;?>" <?php selected( $selection, $id ) ?>><?php echo $name; ?></option>
    <?php endforeach; ?>
    </select>
  </p>
  <?php
}
