<?php

// New Block
add_action('acf/init', 'nc_bigsearch_block');
function nc_bigsearch_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_bigsearch',
            'title'             => __('NC Big Search', 'nc-block-theme'),
            'description'       => __('This creates a search button, that once clicked, displays a large search box that spans the horizon of the viewport at the top of the page.', 'nc-block-theme'),
            'render_callback'   => 'nc_bigsearch_block_markup',
            'category'          => 'layout',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'preview',
            'keywords'          => array('search', 'big search box' ),
			'post_types'        => get_post_types(),
			'align'             => 'none',
			'supports'          => array( 
									'mode' => true,
									'multiple' => false,
				                    'jsx' => false
									),
        ));
}

/* This displays the block */

function nc_bigsearch_block_markup( $block, $content = '', $is_preview = false ) {

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

	/* -------------- ACF Block --------------- */

    $show = get_field('show_search_button');
    $searchtext = get_field('search_text') ?: 'Search...';
?>
    
    <?php if($show):?>
    <?php wp_enqueue_style('nc-blocks-bigsearch');?>

    <label class="ncsearchtrigger" for="ncsearchinput" title="<?php _e('Show search box','nc-block-theme'); ?>">
    <span class="hidetext"><?php _e('Search','nc-block-theme'); ?></span>
    <span class="ncicon nc-search"></span>
    </label>


    <?php /* 
    This form must be place before the closing main header tag
    */?>

    <form name="bigsearch" class="ncsearchreveal" role="search" method="get" 
    action="<?php echo home_url(); ?>/">
    <label class="hidetext" for="ncsearchinput"><?php _e('Search Form','nc-block-theme'); ?></label>
    <input class="ncsearchreveal_input" id="ncsearchinput" name="s" type="search" placeholder="<?php echo esc_html( __( $searchtext, 'nc-block-theme' ) );?>">
    <button class="ncsearchreveal_close" tablindex="0" type="button" title="<?php _e('Close search box','nc-block-theme'); ?>">
    <span class="ncsearchreveal_x ncicon nc-close"></span>
    </button>
    </form>


    <?php else:?>
    <!-- Big search isn't enabled -->
    <?php endif;?>    
	

<?php
}

?>