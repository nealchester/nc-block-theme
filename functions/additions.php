<?php
// Add Excerpts to Pages
add_action( 'init', 'nc_add_excerpts_to_pages' );
function nc_add_excerpts_to_pages() {
add_post_type_support( 'page', 'excerpt' );}



// Add span class around taxonomony count numbers
add_filter('wp_list_categories', 'nc_span_cat_count');
function nc_span_cat_count($links)
{
    $links = str_replace('</a> (', '</a> <span class="nc-amount">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}

// Next Page icon <!--Next Page-->
/*
add_filter('mce_buttons', 'nc_wysiwyg_editor');
function nc_wysiwyg_editor($mce_buttons)
{
    $pos = array_search('wp_more', $mce_buttons, true);
    if ($pos !== false) {
        $tmp_buttons   = array_slice($mce_buttons, 0, $pos + 1);
        $tmp_buttons[] = 'wp_page';
        $mce_buttons   = array_merge($tmp_buttons, array_slice($mce_buttons, $pos + 1));
    }
    return $mce_buttons;
}
*/