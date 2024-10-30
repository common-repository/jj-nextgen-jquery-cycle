<?php

function WPJJNGGJ_CYCLE_plugin_url( $path = '' )
{
  return plugins_url( $path, WPJJNGGJ_CYCLE_PLUGIN_BASENAME );
}

function WPJJNGGJ_CYCLE_enqueue_scripts()
{
  if( !is_admin() )
  {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-jjcucle', WPJJNGGJ_CYCLE_plugin_url( 'script/jquery.cycle.lite.1.0.min.js' ), array('jquery'), '', false );
    wp_enqueue_script( 'jquery-shuffle', WPJJNGGJ_CYCLE_plugin_url( 'script/jquery.jj_ngg_shuffle.js' ), array('jquery'), '', false );
  }
}

function WPJJNGGJ_CYCLE_use_default($instance, $key)
{
  return !array_key_exists($key, $instance) || trim($instance[$key]) == '';
}

function jj_ngg_jquery_cycle_shortcode_handler($atts)
{
  $instance = array();
  foreach($atts as $att => $val)
  {
    $instance[wp_specialchars($att)] = wp_specialchars($val);
  }

  // Set defaults
  if(WPJJNGGJ_CYCLE_use_default($instance, 'html_id')) { $instance['html_id'] = 'cycle_lite'; }
  if(WPJJNGGJ_CYCLE_use_default($instance, 'order')) { $instance['order'] = 'random'; }
  $instance['shortcode'] = '1';

  ob_start();
  the_widget("JJ_NGG_JQuery_Cycle", $instance, array());
  $output = ob_get_contents();
  ob_end_clean();

  return $output;
}

?>