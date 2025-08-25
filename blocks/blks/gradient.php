<?php

// New Block
add_action('acf/init', 'nc_grad_block');
function nc_grad_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_grad',
            'title'             => __('NC Gradient', 'nc-block-theme'),
            'description'       => __('A content box with an image and gradient overlay', 'nc-block-theme'),
            'render_callback'   => 'nc_grad_block_markup',
            'category'          => 'layout',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'preview',
            'keywords'          => array('gradient', 'content' ),
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

function nc_grad_block_markup( $block, $content = '', $is_preview = false ) {

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

	// ACF Vars
	
	$position = get_field('image_position') ?: 'ncgradimg-left';
	$breakpoint = get_field('break_point') ?: '1000';
  
  $picture = get_field('image');
  $image = $picture['url'] ?? null;
  $image_ID = $picture['ID'] ?? null;
  $img_focus = get_field("image_focal_point", $image_ID) ?: '50% 50%';

  if($picture['alt']){
    $img_alt = ' role="img" aria-label="'.esc_attr($picture['alt']).'"';
  }
  else {
    $img_alt = null;
  }

  if($image){ $img = $image; }
  else { $img = nc_block_fallback_image(); };

  $parallax = get_field('image_parallax');
  if($parallax) { $grad_plax = ' ncgradimg_parallaxCSS '; } else { $grad_plax = ' '; };

?>

<?php 
wp_enqueue_style('nc-blocks-gradient'); ?>

<div id="<?php echo $id; ?>" class="ncgradimg<?php echo $grad_plax.$position.esc_attr($className);?>" <?php echo nc_block_attr();?>>

  <div class="ncgradimg_image"<?php echo $img_alt; ?>>
    <div class="ncgradimg_picture"></div>
  </div>

	<div class="ncontain ncgradimg_contain" <?php echo nc_contain_attr();?>>
		<div class="ncgradimg_content" <?php echo nc_animate();?>>
			<?php echo nc_inner_blocks(); ?>
		</div>
	</div>

</div>

<style id="<?php echo $id; ?>-css">

<?php echo '#'.$id; ?>.ncgradimg {
  --height: <?php echo get_field('height') ?: 'min(800px, 100dvh)'; ?>;
  --width: <?php echo get_field('container_width') ?: '1000'; ?>px;
  --content-width: <?php echo get_field('content_width') ?: '50'; ?>%;
  --content-align: left;
  --content-padding: <?php echo get_field('padding') ?: '3rem'; ?>;
  --bgposition: <?php echo $img_focus;?>;
  --bgcolor: <?php echo hex2RGB( get_field('color'), true ); ?>;
  --textcolor: #fff;
  --blend-mode: <?php echo get_field('image_blend_mode') ?: 'normal'; ?>;
  --grad-width: <?php echo get_field('grad_width').'%' ?: '50'; ?>;
  --image-width: <?php echo get_field('image_width').'%' ?: '60'; ?>;
  --bgimage: <?php echo 'url('.$img.')';?>;
}

@media(max-width:<?php if ($breakpoint) { echo $breakpoint.'px'; }; ?>){

  <?php echo '#'.$id; ?>.ncgradimg {
    --content-align:left;
  }
  <?php echo '#'.$id; ?> .ncgradimg_content {
    max-width: 100%;
    padding-block: 1.5rem;
    min-height: 0;
  }

  <?php echo '#'.$id; ?> .ncgradimg_contain {
    min-height: 0;
  }

  <?php echo '#'.$id; ?> .ncgradimg_image {
    height: auto;
    width: 100%;
    position: relative;
  }

  <?php echo '#'.$id; ?> .ncgradimg_image:after {
    content: "";
    padding-top: <?php echo get_field('image_height') ?: '100';?>%;
    display: block;
    width: 100%;
  }

  <?php echo '#'.$id; ?> .ncgradimg_image:before {
    height: var(--grad-width);
    width: 100%;
    left: 0;
    top: auto;
    bottom: -1px;
    background-image: 
      linear-gradient(
        to top, 
        var(--gradient-smooth) 
      ) !important;
  }

}

<?php nc_block_custom_css();?>

</style>

<?php } ?>