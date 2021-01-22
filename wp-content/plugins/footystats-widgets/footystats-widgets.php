<?php

/**
 * Plugin Name:       FootyStats Widgets
 * Plugin URI:        https://footystats.org/embeds
 * Description:       Live Football / Soccer Widgets by FootyStats.org
 * Version:           1.2
 * Requires at least: 5.2
 * Requires PHP:      5.3
 * Author:            FootyStats.org
 * Author URI:        https://footystats.org
 * Text Domain:       footystats_widgets
 * Domain Path:       /languages
 */

 if(!defined('ABSPATH')){exit;}

//  Load CSS + Scrips
 require_once(plugin_dir_path(__FILE__).'/footystats-widgets-scripts.php');
 //  Load Class
require_once(plugin_dir_path(__FILE__).'/footystats-widgets-class.php');

function footystats_registerWidgets(){
  register_widget('footystats_StandingsWidget');
  register_widget('footystats_NextFixtureWidget');
  register_widget('footystats_FixturesWidget');
  register_widget('footystats_Upcoming_RoundWidget');
  register_widget('footystats_Previous_RoundWidget');
}

add_action('widgets_init', 'footystats_registerWidgets');

 ?>