<?php
/**
 * Take over the update check
 *
 * @version 2.0.0
 * @param   object $checked_data
 * @return  object
 */
function myarcadetheme_update_check( $checked_data ) {

  if ( empty($checked_data->checked) ) {
    return $checked_data;
  }

  // Collect theme data
  $theme_base = get_option( 'template' );
  $theme_data = wp_get_theme( $theme_base );
  $theme_version = $theme_data->Version;

  $request_args = array(
    'slug' => $theme_base,
    'version' => $theme_data->Version,
  );

  $request_string = myarcadetheme_prepare_request( 'theme_update', $request_args );

  // Start checking for an update
  $raw_response = wp_remote_post( 'http://api.myarcadeplugin.com/theme_update.php', $request_string );

  if (! is_wp_error($raw_response) && isset( $raw_response['response']['code']) && ( $raw_response['response']['code'] == 200) ) {
    $response = unserialize( $raw_response['body'] );
  }

  if ( ! empty( $response ) ) {
    // Feed the update data into WP updater
    $checked_data->response[$theme_base] = $response;
  }

  return $checked_data;
}
add_filter('pre_set_site_transient_update_themes', 'myarcadetheme_update_check');

/**
 * Create request query for the update check
 *
 * @version 2.0.0
 * @param   string $action
 * @param   array  $args
 * @return  array
 */
function myarcadetheme_prepare_request( $action, $args ) {
  global $wp_version;

  return array (
    'body' => array (
      'action'  => $action,
      'request' => serialize($args),
      'url'     => home_url(),
      'key'     => '',
      'item'    => $args['slug'],
    ),
    'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
  );
}
//set_site_transient('update_themes', null);