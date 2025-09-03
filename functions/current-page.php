<?php
function nc_current_page_shortcode( $atts ) {
    // Get the global WP_Query object
    $query_obj = $GLOBALS['wp_query'];

    // Check if the query object exists and has the required properties
    if ( ! is_a( $query_obj, 'WP_Query' ) || ! isset( $query_obj->max_num_pages ) ) {
        return '';
    }

    $pages = $query_obj->max_num_pages;
    if ( $pages < 1 ) {
        return '';
    }

    $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

    // Build the output string
    $output = '<p class="ncurrentpage txt-small"> <span class="ncurrentpage_label">' . esc_html__( 'You\'re on page', 'your-text-domain' ) . '</span> <span class="ncurrentpage_number">' . esc_html( $page ) . '</span> <span class="ncurrentpage_of">' . esc_html__( 'of', 'your-text-domain' ) . '</span> <span class="ncurrentpage_total">' . esc_html( $pages ) . '</span></p>';
    
    return $output;
}
add_shortcode( 'current_page_info', 'nc_current_page_shortcode' );
?>