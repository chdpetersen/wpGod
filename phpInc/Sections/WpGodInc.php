<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) || !defined( 'ABSPATH' ) || !defined( 'WPGODPATH' ) || !defined( 'WPGODURL' )) {
	die;
}
/**
 * Displays the HTML for the DB Analysis
 */
function wpgod_page_html() {
  // Check user capabilities
    if ( ! current_user_can( "manage_options" ) ) {
        return;
    }
    
   $getDBAnalysis = new \Sections\WpGod();
   $getDBAnalysis->getWpGodHtml();
}