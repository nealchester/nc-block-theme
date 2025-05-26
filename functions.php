<?php

// Load Gutenberg (Folder)
get_template_part('blocks/block-setup');

// Plugins (Folder)
get_template_part('plugins/list');

// Customizer addons (Folder) + Add Customizer Link Back   
get_template_part('customizer/_controls');
add_action( 'customize_register', '__return_true' );


// ------------------------------------------------ //


// ACF JSON Link
get_template_part('functions/acf-json');


// Add theme support for various things
get_template_part('functions/add-theme-support');


// Image Focus Function
get_template_part('functions/image-focus');


// Load External Fonts
get_template_part('functions/register-fonts');


// Load Scripts and Styles
get_template_part('functions/register-css-js');


// ACF Theme fields
get_template_part('functions/theme-acf-fields');


// New User fields
get_template_part('functions/new-user-fields');


// Default Link for empty Nav Menu
get_template_part('functions/link-to-editor');


// Current Page
get_template_part('functions/current-page');


// Body Class Additions
get_template_part('functions/body-classes');


// Modify author archive post number to all
// get_template_part('functions/author-article-amount');



/* Add the following:
	- Descriptions to menu items
	- Excerpts to Pages
	- Span class around taxonomy count numbers
	- Max content width
	- Next Page button to editor
*/
get_template_part('functions/additions');


/* Remove the following:
	- Recent comment weird output
	- The gallery styles
*/
get_template_part('functions/removals');


/* Add signature in the HTML */

function nc_footer_signature(){
echo "\n<!--\nDeveloped from the NC Block Theme Framework
by nealchester.com | github.com/nealchester/nc-block-theme/\n-->\n\n";
}
add_action('wp_footer','nc_footer_signature', 100);

?>