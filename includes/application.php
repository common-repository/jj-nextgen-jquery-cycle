<?php

require_once WPJJNGGJ_CYCLE_PLUGIN_DIR . '/includes/functions.php';
require_once WPJJNGGJ_CYCLE_PLUGIN_DIR . '/includes/jj_ngg_jquery_cycle.php';

add_action( 'widgets_init', create_function('', 'return register_widget("JJ_NGG_JQuery_Cycle");') );
add_shortcode( 'jj-ngg-jquery-cycle', 'jj_ngg_jquery_cycle_shortcode_handler' );

if( !is_admin() )
{
  add_action( 'init', 'WPJJNGGJ_CYCLE_enqueue_scripts' );
}

?>