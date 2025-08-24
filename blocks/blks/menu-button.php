<?php

// New Block
add_action('acf/init', 'nc_menubtn_block');
function nc_menubtn_block() {

	// register a items block
	acf_register_block_type(array(
			'name'              => 'nc_menubtn',
			'title'             => __('NC Menu Button', 'nc-block-theme'),
			'description'       => __('Menu button that will open the mobile menu', 'nc-block-theme'),
			'render_callback'   => 'nc_menubtn_block_markup',
			'category'          => 'common',
			'icon'              => get_nc_icon('nc-block'),
			'mode'              => 'preview',
			'keywords'          => array('menu button', 'button' ),
			'post_types'        => get_post_types(),
			'align'             => 'none',
			'supports'          => array( 
				'align' => 'none', 
				'mode' => true,
				'multiple' => false,
				'jsx' => false
				),
	));
}

/* This displays the block */

function nc_menubtn_block_markup( $block, $content = '', $is_preview = false ) {

	// ID Setup
	if (get_field('set_id')) { $id = get_field('set_id'); } else { $id = uniqid("block_"); };

	//ACF Block
	$dwidth = get_field('display_width') ?: '784';

	$hlabel = get_field('hide_label');
	if( $hlabel ) { $hide = ' hide'; } else { $hide = null; }

?>

<?php wp_enqueue_style('nc-blocks-mmenu');?>
	
<label hidden="" for="mmenu" class="mm_button" aria-hidden="true">
	<span class="ncicon"></span>
	<div class="mm_btnlabel<?php echo $hide; ?>"><?php _e('Menu', 'nc-block-theme');?></div>
</label>

<style id="mm_button-mm_panel-css">

	@media(max-width:<?php echo $dwidth;?>px){
		.wp-site-blocks .mm_button { 
			display:flex; 
		}

		.wp-site-blocks #header,
		[data-title="Header"] { 
			nav[aria-label="main-nav-desktop"],
			nav[aria-label="Navigation"],
			nav.main-nav-desktop { 
				display:none; 
			}
		}
		
	}

	@media(min-width:<?php echo $dwidth;?>px){
		.wp-site-blocks {
			.mm_panel,
			.mm_underlay { 
				display:none;
			}
		}
		:has(.mm_input:checked) body {
			overflow:auto;
		}
	}

</style>

<?php } ?>