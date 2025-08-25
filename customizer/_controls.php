<?php
// Remove some of WordPress Customizer controls
get_template_part('customizer/_remove');

// Layout Panel
get_template_part('customizer/_layout-panel');

// Sanitize Customizer
get_template_part('customizer/_sanitize');

// ---------------------------------------------------- //

// Address bar color
get_template_part('customizer/bar-color');

//  Dev options section
get_template_part('customizer/options-dev');
?>