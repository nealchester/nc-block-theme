<?php 
/*

Un-comment this file and add your external font URL 
along with preconnects link as prescribed by the external font provider.



// External Font URL
function nc_external_font_url(){
  return 'https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap'; // Add your external font address here 
}

// Preload External Fonts
function nc_preload_external_fonts() {
  echo '
  <link rel="preconnect" href="https://fonts.googleapis.com">';
  echo '
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'nc_preload_external_fonts', 5);


// Register and Enqueue External Fonts
function nc_load_external_font_files(){
    wp_register_style('external-fonts', nc_external_font_url(), null, null, 'screen');
    wp_enqueue_style('external-fonts');
}
add_action('wp_enqueue_scripts', 'nc_load_external_font_files');

*/