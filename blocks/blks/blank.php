<?php

// New Block
add_action('acf/init', 'nc_blank_block');
function nc_blank_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_blank',
            'title'             => __('NC Blank Box', 'nc-block-theme'),
            'description'       => __('A blank box to write text or HTML into.', 'nc-block-theme'),
            'render_callback'   => 'nc_blank_block_markup',
            'category'          => 'layout',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'preview',
            'keywords'          => array('blank', 'section' ),
			'post_types'        => get_post_types(),
			'align'             => 'full',
			'supports'          => array( 
									'align' => array( 'wide', 'full' ), 
									'mode' => true,
									'multiple' => true,
									),
        ));
}

/* This displays the block */

function nc_blank_block_markup( $block, $content = '', $is_preview = false ) {

	// ID Setup
    if (get_field('set_id')) { $id = get_field('set_id'); } else { $id = uniqid("block_"); };

    // Create class attribute allowing for custom "className" and "align" values.
    $className = '';
    if( !empty($block['className']) ) {
        $className .= ' ' . $block['className'];
    }
    if( !empty($block['align']) ) {
        $className .= ' align' . $block['align'];
    }

	//ACF Block
	$tcontent = get_field('text_content');

?>
	<section id="<?php echo $id; ?>" class="ncblank<?php echo esc_attr($className); ?>" <?php echo nc_block_attr();?>>
        <div class="ncontain" <?php echo nc_animate();?>>
       
        <?php if($tcontent):?><?php echo '<div class="nc_content_block_main">'.$tcontent.'</div>';?>
            <?php else:?> 
                
        <div class="nocontent">
        <p><?php _e('Add some content to start. Use the sidebar settings to begin.','nc-block-theme');?></p>
        </div>

        <?php endif; ?>

		</div>
	</section>

<style id="<?php echo $id; ?>-css">

<?php nc_box_styles($id); ?>

<?php nc_block_custom_css(); ?>

</style>

<?php
}

?>