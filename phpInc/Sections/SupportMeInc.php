<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) || !defined( 'ABSPATH' ) || !defined( 'WPGODPATH' ) || !defined( 'WPGODURL' )) {
	die;
}
/**
 * Displays the HTML for the WpGod Donations page.
 */
 function wpgod_supportme_page_html() {
    // Check user capabilities
    if ( ! current_user_can( "manage_options" ) ) {
        return;
    }
   
    $getSupportMe = new \Sections\SupportMe();
    $getSupportMe->getSupportMe();
   
} 