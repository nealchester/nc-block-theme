<?php

// New Block
add_action('acf/init', 'nc_menupanel_block');
function nc_menupanel_block() {

	// register a items block
	acf_register_block_type(array(
			'name'              => 'nc_menupanel',
			'title'             => __('NC Menu Panel', 'nc-block-theme'),
			'description'       => __('Menu panel', 'nc-block-theme'),
			'render_callback'   => 'nc_menupanel_block_markup',
			'category'          => 'common',
			'icon'              => get_nc_icon('nc-block'),
			'mode'              => 'preview',
			'keywords'          => array('mobile panel', 'mobile menu' ),
			'post_types'        => get_post_types(),
			'align'             => 'none',
			'supports'          => array( 
				'align' => 'none', 
				'mode' => true,
				'multiple' => false,
				'jsx' => true
				),
	));
}

/* This displays the block */

function nc_menupanel_block_markup( $block, $content = '', $is_preview = false ) {

	// ID Setup
	if (get_field('set_id')) { $id = get_field('set_id'); } else { $id = uniqid("block_"); };

	//ACF Block
	

?>

<?php wp_enqueue_style('nc-blocks-mmenu');?>
	
<!-- Mobile Menu Panel -->

<input class="hide mm_input" type="checkbox" id="mmenu" name="nc_show_menu" value="mpanel">

<div class="mm_panel" id="<?php echo $id; ?>">

	<label class="mm_close" for="mmenu" aria-hidden="true">
		<span class="ncicon nc-close"></span>
	</label>

	<?php echo nc_inner_blocks(); ?>

</div>

<label class="mm_underlay" for="mmenu" aria-hidden="true"></label>

<?php } ?>