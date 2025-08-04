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

        if ($dp_divider) { $dp_div_display = 'block'; } else { $dp_div_display = 'none'; }
        
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

?>
    <?php wp_enqueue_style('nc-blocks-columns');?>

	<div id="<?php echo $id; ?>" class="ncol<?php echo ' '.$dp_style.esc_attr($className); ?>" <?php echo nc_block_attr();?>>
        <?php echo nc_inner_blocks(); ?>
    </div>

    <style id="<?php echo $id; ?>-css">

    <?php echo '#'.$id;?>.ncol {
        --col-style: <?php echo $dp_cssblk; ?>;
        --col-spacing: <?php echo $dp_spacing; ?>;
        --col-row-spacing: <?php echo $dp_rspacing; ?>;
        --col-width: <?php echo $dp_width; ?>;
        --col-num: <?php echo $dp_count; ?>;
        --col-div-display: <?php echo $dp_div_display; ?>;
    }

    <?php // Tablet Display
    $tb_display = get_field('tablet_display');
    if( $tb_display ):?>

    @media(max-width:<?php echo $tb_display.'px'; ?>){

        <?php
        $tb_count = get_field('tb_column_count') ?: '3';
        $tb_spacing = get_field('tb_column_spacing');
        $tb_rspacing = get_field('tb_column_row_spacing');
        $tb_width = get_field('tb_column_width');
        $tb_divider = get_field('tb_column_divider');
        ?>

        <?php if ($tb_divider) { $tb_div_display = 'block'; } else { $tb_div_display = 'none'; }?>

        <?php $tb_style = get_field('tb_column_style');?>

        <?php if( $tb_style == 'ncol_fill' ):?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout {
            display: grid;
            column-gap: var(--col-spacing, 2rem);
            row-gap: var(--col-row-spacing, 2rem);
            grid-template-columns: 
                repeat( auto-fit, 
                minmax( min( var(--col-width, 250px), 100%), 1fr )
                );
            
            grid-auto-flow: unset;

            & > * {
            min-width: unset;
            margin-bottom: unset;
            scroll-snap-align: unset;
            }
        }

        <?php elseif( $tb_style == 'ncol_fixed' ) :?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout {
            display: grid;
            column-gap: var(--col-spacing, 2rem);
            row-gap: var(--col-row-spacing, 2rem);
            grid-template-columns: repeat(var(--col-num, 3), 1fr);
            grid-auto-flow: unset;

            & > * {
            min-width: unset;
            margin-bottom: unset;
            scroll-snap-align: unset;
            }
        }

        <?php elseif( $tb_style == 'ncol_overflow' ) :?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout  {
            display:grid;
            column-gap: var(--col-spacing, 2rem);
            grid-template-columns: auto;
            grid-auto-flow: column;
            overflow-x:auto;
            overflow-y:hidden;
            overscroll-behavior-inline: contain;
            scroll-snap-type: inline mandatory;
            scroll-padding-inline: var(--gap);
            margin-bottom: calc(-1 * var(--col-spacing, 2rem));
            padding-inline:var(--gap);
            margin-inline: calc(-1 * var(--gap));
            
            max-width:100% !important; 
            width:100% !important;
            

            & > * { 
            min-width: var(--col-width, 250px); 
            margin-bottom: var(--col-row-spacing, 2rem);
            scroll-snap-align: start
            }  
        }

        <?php elseif( $tb_style == 'ncol_spaced' ) :?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout  {
            display: flex;
            column-gap: var(--col-spacing, 2rem);
            row-gap: var(--col-row-spacing, 2rem);
            justify-content: space-between;
            align-items: stretch;
            overflow-x: auto;
            overflow-y: auto;
            margin-bottom: unset;
            padding-inline: unset;
            margin-inline: unset;

            & > * {
            flex-basis: min( var(--col-width, 250px), 100%);
            min-width: 0;
            margin-bottom: unset;
            }
        }

        <?php elseif( $tb_style == 'ncol_centered' ) :?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout  {
            display: flex;
            column-gap: var(--col-spacing, 2rem);
            row-gap: var(--col-row-spacing, 2rem);
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
            overflow-x: auto;
            overflow-y: auto;
            margin-bottom: unset;
            padding-inline: unset;
            margin-inline: unset;

            & > * {
            flex-basis: min( var(--col-width, 250px), 100%);
            min-width: 0;
            margin-bottom: unset;
            }
        }

        <?php endif;?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout {
            /* Variables Updated */
            --col-spacing: <?php echo $tb_spacing; ?>;
            --col-row-spacing: <?php echo $tb_rspacing; ?>;
            --col-width: <?php echo $tb_width; ?>;
            --col-num: <?php echo $tb_count; ?>;
            --col-div-display: <?php echo $tb_div_display; ?>;
        }

    }

    <?php endif;?>

    <?php // Phone Display
    $ph_display = get_field('phone_display');
    if( $ph_display ):?>

    @media(max-width:<?php echo $ph_display.'px'; ?>){

        <?php
        $ph_count = get_field('ph_column_count') ?: '3';
        $ph_spacing = get_field('ph_column_spacing');
        $ph_rspacing = get_field('ph_column_row_spacing');
        $ph_width = get_field('ph_column_width');
        $ph_divider = get_field('ph_column_divider');
        ?>

        <?php if ($ph_divider) { $ph_div_display = 'block'; } else { $ph_div_display = 'none'; }?>

        <?php $ph_style = get_field('ph_column_style');?>

        <?php if( $ph_style == 'ncol_fill' ):?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout {
            display: grid;
            column-gap: var(--col-spacing, 2rem);
            row-gap: var(--col-row-spacing, 2rem);
            grid-template-columns: 
                repeat( auto-fit, 
                minmax( min( var(--col-width, 250px), 100%), 1fr )
                );
            
            grid-auto-flow: unset;

            & > * {
            min-width: unset;
            margin-bottom: unset;
            scroll-snap-align: unset;
            }
        }

        <?php elseif( $ph_style == 'ncol_fixed' ) :?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout {
            display: grid;
            column-gap: var(--col-spacing, 2rem);
            row-gap: var(--col-row-spacing, 2rem);
            grid-template-columns: repeat(var(--col-num, 3), 1fr);
            grid-auto-flow: unset;

            & > * {
            min-width: unset;
            margin-bottom: unset;
            scroll-snap-align: unset;
            }
        }

        <?php elseif( $ph_style == 'ncol_overflow' ) :?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout  {
            display:grid;
            column-gap: var(--col-spacing, 2rem);
            grid-template-columns: auto;
            grid-auto-flow: column;
            overflow-x:auto;
            overflow-y:hidden;
            overscroll-behavior-inline: contain;
            scroll-snap-type: inline mandatory;
            scroll-padding-inline: var(--gap);
            margin-bottom: calc(-1 * var(--col-spacing, 2rem));
            padding-inline:var(--gap);
            margin-inline: calc(-1 * var(--gap));
            
            max-width:100% !important; 
            width:100% !important;
            

            & > * { 
            min-width: var(--col-width, 250px); 
            margin-bottom: var(--col-row-spacing, 2rem);
            scroll-snap-align: start
            }  
        }

        <?php elseif( $ph_style == 'ncol_spaced' ) :?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout  {
            display: flex;
            column-gap: var(--col-spacing, 2rem);
            row-gap: var(--col-row-spacing, 2rem);
            justify-content: space-between;
            align-items: stretch;
            overflow-x: auto;
            overflow-y: auto;
            margin-bottom: unset;
            padding-inline: unset;
            margin-inline: unset;

            & > * {
            flex-basis: min( var(--col-width, 250px), 100%);
            min-width: 0;
            margin-bottom: unset;
            }
        }

        <?php elseif( $ph_style == 'ncol_centered' ) :?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout  {
            display: flex;
            column-gap: var(--col-spacing, 2rem);
            row-gap: var(--col-row-spacing, 2rem);
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
            overflow-x: auto;
            overflow-y: auto;
            margin-bottom: unset;
            padding-inline: unset;
            margin-inline: unset;

            & > * {
            flex-basis: min( var(--col-width, 250px), 100%);
            min-width: 0;
            margin-bottom: unset;
            }
        }

        <?php endif;?>

        <?php echo '#'.$id;?>.ncol,
        <?php echo '#'.$id;?>.ncol > .block-editor-inner-blocks > .block-editor-block-list__layout {
            /* Variables Updated */
            --col-spacing: <?php echo $ph_spacing; ?>;
            --col-row-spacing: <?php echo $ph_rspacing; ?>;
            --col-width: <?php echo $ph_width; ?>;
            --col-num: <?php echo $ph_count; ?>;
            --col-div-display: <?php echo $ph_div_display; ?>;
        }

    }

    <?php endif;?>    

    <?php nc_block_custom_css(); ?>

    </style>

<?php
}

?>