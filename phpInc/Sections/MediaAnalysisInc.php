<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) || !defined( 'ABSPATH' ) || !defined( 'WPGODPATH' ) || !defined( 'WPGODURL' )) {
	die;
}
/**
 * Displays the HTML for the Media Analysis
 */
function wpgod_media_analysis_page_html() {
    // Check user capabilities
    if ( ! current_user_can( "manage_options" ) ) {
        return;
    }
     
    $getMediaAnalysis = new \Sections\MediaAnalysis();
    $getMediaAnalysis->getMediaAnalysisHtml();
}