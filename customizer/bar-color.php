<?php

// Colors for customiizer

function nc_color_control( $wp_customize ) {
    $wp_customize->add_section('nc_color_section', array(
        'title' => __('Address Bar Color','nc-framework'),
        'description' => '',
        'priority' => 50,
   ));
	 
	// mobile address bar color
	$txtcolors[] = array(
		 'slug'=>'address_bar_color', 
		 'default' => '',
		 'label' => __('Mobile address bar color','nc-framework')
	);	
 
 
	// add the settings and controls for each color
	foreach( $txtcolors as $txtcolor ) {
	 
		 // SETTINGS
		 $wp_customize->add_setting(
			  $txtcolor['slug'], array(
					'default' => $txtcolor['default'],
					'type' => 'option', 
					'capability' => 
					'edit_theme_options',
					'sanitize_callback' => 'nc_sanitize_text'
			  )
		 );
		 // CONTROLS
		 $wp_customize->add_control(
			  new WP_Customize_Color_Control(
					$wp_customize,
					$txtcolor['slug'], 
					array('label' => $txtcolor['label'], 
					'section' => 'nc_color_section',
					'settings' => $txtcolor['slug'])
			  )
		 );
	}	
 
 
}
add_action( 'customize_register', 'nc_color_control' );

// Print the styles to the head

function nc_color_control_css(){
	echo'<meta name="theme-color" content="'.get_option('address_bar_color').'" />';
}
add_action( 'wp_head', 'nc_color_control_css', 100 );

?>