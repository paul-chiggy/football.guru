<?php

function footystats_addScripts(){

  // Add CSS
  wp_enqueue_style('fs-standings-css', plugin_dir_url( __FILE__ ).'/css/standings.css');
  wp_enqueue_style('fs-next-fixture-css', plugin_dir_url( __FILE__ ).'/css/next_fixture.css');
  wp_enqueue_style('fs-fixtures-css', plugin_dir_url( __FILE__ ).'/css/fixtures.css');
  // wp_enqueue_style('fs-upcoming-round-css', plugin_dir_url( __FILE__ ).'/css/upcoming_round.css');
}

function footystats_loadScripts(){
  wp_enqueue_script('jquery');
  wp_register_script( 
      'fs_script', 
      plugin_dir_url( __FILE__ ) . '/js/admin.js', 
      array( 'jquery' ), time()
  );
  wp_enqueue_script( 'fs_script' );
}
add_action('admin_enqueue_scripts', 'footystats_loadScripts');
add_action('wp_enqueue_scripts', 'footystats_addScripts');

?>