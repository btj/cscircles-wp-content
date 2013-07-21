<?php

if (defined('ABSPATH')) {
  echo "Error, WordPress is already loaded!";
  debug_print_backtrace();
  exit(0);
 }

// used for external/ajax access to wordpress functions
// http://codex.wordpress.org/Integrating_WordPress_with_Your_Website

// from this file (include-me-if-ajax), look at the containing directory
// (pybox) and up 3 more (plugins, wp-content, wordpress) for wp-load.php 
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php');
// we can't use ABSPATH because it's not defined (an ajax call is in progress)

// now wordpress is installed. Huzzah!

// we only need this for ajax calls:
if (array_key_exists('polylang', $GLOBALS)) 
  $GLOBALS['polylang']->load_textdomains();

// this is to avoid errors shown if WP_DEBUG is on
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action( 'shutdown', 'tweaked_wp_ob_end_flush_all', 1 );

function tweaked_wp_ob_end_flush_all() {
	$levels = ob_get_level();
	for ($i=0; $i<$levels; $i++)
		@ob_end_flush();
}

// end of file