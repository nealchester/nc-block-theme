<?php

// New Block
add_action('acf/init', 'nc_columns_block');
function nc_columns_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_columns',
            'title'             => __('NC Columns Box', 'nc-block-theme'),
            'description'       => __('A container that manages column content.', 'nc-block-theme'),
            'render_callback'   => 'nc_columns_block_markup',
            'category'          => 'layout',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'preview',
            'keywords'          => array('columns', 'column' ),
			'post_types'        => get_post_types(),
			'align'             => 'wide',
			'supports'          => array( 
									'align' => array( 'wide', 'full' ), 
									'mode' => true,
									'multiple' => true,
				                    'jsx' => true
									),
        ));
}

/* This displays the block */

function nc_columns_block_markup( $block, $content = '', $is_preview = false ) {

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

    // Desktop
        $dp_count = get_field('column_count') ?: '3';
        $dp_spacing = get_field('column_spacing');
        $dp_rspacing = get_field('column_row_spacing');
        $dp_width = get_field('column_width');
        $dp_divider = get_field('column_divider');

        if ($dp_divider) { $dividers = 'ncol_dividers'; } else { null; }
        
        $dp_style = get_field('column_style');

        if( $dp_style == 'ncol_fill' or $dp_style == 'ncol_fixed' or $dp_style == 'ncol_overflow'){
            $dp_cssblk = 'grid';
        }
        elseif( $dp_style == 'ncol_centered' or $dp_style == 'ncol_spaced'){
            $dp_cssblk = 'flex';
        }
        else {
            $dp_cssblk = 'grid';
        }

        if ($dp_style == 'ncol_overflow') {
            $fullwidth = 'max-width:100% !important; width:100% !important;';
        }
        else {
            $fullwidth = null;
        }

?>
    <?php wp_enqueue_style('nc-blocks-columns');?>

	<div id="<?php echo $id; ?>" class="ncol<?php echo ' '.$dp_style.' '.$dividers.esc_attr($className); ?>" <?php echo nc_block_attr();?>>
        <?php echo nc_inner_blocks(); ?>
    </div>

    <style id="<?php echo $id; ?>-css">

    <?php echo '#'.$id;?>.ncol {
        --col-style: <?php echo $dp_cssblk; ?>;
        --col-spacing: <?php echo $dp_spacing; ?>;
        --col-row-spacing: <?php echo $dp_rspacing; ?>;
        --col-width: <?php echo $dp_width; ?>;
        --col-num: <?php echo $dp_count; ?>;
        
        <?php echo $fullwidth; ?>
    }

    <?php nc_block_custom_css(); ?>

    </style>

<?php
}

?>