<?php

// New Block
add_action('acf/init', 'nc_hero_block');
function nc_hero_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_hero',
            'title'             => __('NC Hero', 'nc-block-theme'),
            'description'       => __('A hero block with animation, parallax, and content positioning options.', 'nc-block-theme'),
            'render_callback'   => 'nc_hero_block_markup',
            'category'          => 'layout',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'preview',
            'keywords'          => array('hero', 'splash' ),
						'post_types'        => get_post_types(),
						'align'             => 'full',
						'supports'          => array( 
							'align' => array( 'wide', 'full' ), 
							'mode' => true,
							'multiple' => true,
							'jsx' => true,
							),
        ));
}


/* This displays the block */

function nc_hero_block_markup( $block, $content = '', $is_preview = false ) {

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
	$content = get_field('content');
	$image = get_field('image');
	$image_mobile = get_field('image_mobile');
	$media_query = get_field('media_query');	
	$focus = nc_block_focal();
	$focus_mobile = get_field('image_focus_mobile') ?: '50% 50%';
	$o_opacity = get_field('overlay_opacity') ?: '0.5';
	$o_color = get_field('overlay_color') ?: '#000';
	$o_blend = get_field('overlay_blend_mode') ?: 'normal';
	$img_blend = get_field('image_blend_mode') ?: 'normal';
	$t_color = get_field('text_color') ?: '#fff';
	$t_align = get_field('text_align') ?: 'left';
	$shadow = get_field('drop_shadow') ?: '0 2px 6px rgba(0,0,0,0.3)';
	$content_width = get_field('max_content_width') ?: '700px';
	$contain_width = get_field('max_container_width') ?: '1400px';
	$c_x = get_field('content_position_x') ?: 'center';
	$c_y = get_field('content_position_y') ?: 'center';
	$c_padding = get_field('content_padding') ?: '3rem 0';
	$min_height = get_field('block_min_height') ?: '85dvh';
	$bgcolor = get_field('background_color') ?: '#000';

	$plax = get_field('parallax');
	if($plax) { $plax_css = ' nchero_parallaxCSS'; } else { $plax_css = null; }
?>



<?php 
	wp_enqueue_style('nc-blocks-hero');
	?>

	<section id="<?php echo $id; ?>" class="nchero<?php echo $plax_css.esc_attr($className); ?>"<?php echo ' '.nc_block_attr();?>>

	<?php // nc_before_content(); ?>

		<?php if($image):?>
		<div class="nchero_image"></div>

		<?php else: ?>
		<div class="nchero_image" style="background-image:<?php nc_block_fallback_image(); ?>"></div>

		<?php endif;?>

		<div class="ncontain">
			<div class="nchero_content"<?php echo ' '.nc_animate();?>>
				<?php echo nc_inner_blocks(); ?>
			</div>
		</div>

		<?php // nc_after_content(); ?>

		</section>

<style id="<?php echo $id; ?>-block-css">

	<?php echo '#'.$id; ?>.nchero {
		--overlay-opacity: <?php echo $o_opacity.";\n"; ?>
		--overlay-color: <?php echo $o_color.";\n"; ?>
		--overlay-blend-mode: <?php echo $o_blend.";\n"; ?>

		--image-focus: <?php echo $focus.";\n"; ?>
		--image-blend-mode: <?php echo $img_blend.";\n"; ?>

		--text-color: <?php echo $t_color.";\n"; ?>
		--text-align: <?php echo $t_align.";\n"; ?>

		--max-container-width: <?php echo $contain_width."px;\n"; ?>

		--content-dropshadow: <?php echo $shadow.";\n"; ?>
		--content-max-width: <?php echo $content_width."px;\n"; ?>
		--content-position-x: <?php echo $c_x.";\n"; ?>
		--content-position-y: <?php echo $c_y.";\n"; ?>
		--content-padding: <?php echo $c_padding.";\n"; ?>

		--box-min-height: <?php echo $min_height.";\n"; ?>
		--box-bgcolor: <?php echo $bgcolor.";\n"; ?>
		}

		.editor-styles-wrapper <?php echo '#'.$id; ?> .nchero_image { height:100%; }
		
		/* Main Image */

		<?php echo '#'.$id; ?> .nchero_image {
			background-image: url('<?php echo wp_get_attachment_image_url( $image, 'full'); ?>');	
		}

		<?php if($image_mobile && $media_query):?>

		@media(max-width:<?php echo $media_query.'px';?>) {	

			<?php echo '#'.$id; ?> .nchero_image {
				background-image:url(<?php echo wp_get_attachment_image_url( $image_mobile, 'full'); ?>);
			}
			<?php echo '#'.$id; ?> {
				--image-focus: <?php echo $focus_mobile;?>;
			}

		}
		<?php endif;?>

	<?php nc_block_custom_css(); ?>

</style>

<?php }?>