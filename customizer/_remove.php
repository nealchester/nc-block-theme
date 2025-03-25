<?php

// If you'd like to remove any customizer features add them below. To remove Logo upload, comment out this feature in "add-theme-support.php" in the "functions" folder. 
// Credit: https://wp-kama.com/handbook/theme/customize-api/remove

function nc_customizer_remove($wp_customize){

    // $wp_customize->remove_section('name_of_feature');
    $wp_customize->remove_section( 'static_front_page' );
    $wp_customize->remove_section( 'custom_css' );
    $wp_customize->remove_section( 'title_tagline' );
    
}
add_action('customize_register', 'nc_customizer_remove');
