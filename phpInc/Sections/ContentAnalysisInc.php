<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) || !defined( 'ABSPATH' ) || !defined( 'WPGODPATH' ) || !defined( 'WPGODURL' )) {
	die;
}
/**
 * Displays the HTML for the Content Analysis
 */
function wpgod_content_analysis_page_html() {
  // Check user capabilities
    if ( ! current_user_can( "manage_options" ) ) {
        return;
    }
    
   $getContentAnalysis = new \Sections\ContentAnalysis();
   $getContentAnalysis->getContentAnalysisHtml();
}    