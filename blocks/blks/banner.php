<?php

// New Block
add_action('acf/init', 'nc_banner_block');
function nc_banner_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_banner',
            'title'             => __('NC Banner Heading', 'nc-block-theme'),
            'description'       => __('Display a heading with an image in the background.', 'nc-block-theme'),
            'render_callback'   => 'nc_banner_block_markup',
            'category'          => 'layout',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'preview',
            'keywords'          => array('banner', 'banner heading', 'banner header' ),
            'post_types'        => get_post_types(),
            'align'             => 'none',
            'supports'          => array( 
                                  'mode' => true,
                                  'multiple' => false,
                                  'jsx' => true
                                  ),
        ));
}

/* This displays the block */

function nc_banner_block_markup( $block, $content = '', $is_preview = false ) {

	  // ID Setup
    if (get_field('set_id')) { $id = get_field('set_id'); } 
      else { $id = uniqid("block_");
    };
    // Create class attribute allowing for custom "className" and "align" values.
    $className = '';
    if( !empty($block['className']) ) {
        $className .= ' ' . $block['className'];
    }
    if( !empty($block['align']) ) {
        $className .= ' align' . $block['align'];
    }

	/* -------------- ACF Block --------------- */

    $show = get_field('show_banner');
?>
    
    <?php if( !is_page_template( 'blank' ) && !is_author() && $show ):?>

    <?php 
      $show_avatar = get_field('show_author_meta');
      $dimage = get_field('default_image');
      $default_image = $dimage['url']; 
      $default_image_ID = $dimage['ID']; 
    ?>

    <?php wp_enqueue_style('nc-blocks-banner');?>

    <?php

      // If Blog homepage

      if ( function_exists('get_field') && has_post_thumbnail() && is_home() ) {
      $thumbnail = get_option( 'page_for_posts' );
      
      $page_id = get_queried_object_id();
      $pID = get_post( get_post_thumbnail_id($page_id) );
      $img_focus = 'background-position:'.get_field("image_focal_point", $pID);

      $img_desc  = '';	
      $image_url = get_the_post_thumbnail_url($thumbnail);
      $image_bg = 'style="background-image:url('.$image_url.'); '.$img_focus.';"';
      }

      // If Singular (Posts or Pages) and NOT the Blog homepage

      elseif ( has_post_thumbnail() && !is_home() && is_singular() ) {

      $thumbnail = get_post( get_post_thumbnail_id() );
      $img_focus = 'background-position:'.get_field("image_focal_point", $thumbnail);

      if( get_post_meta($thumbnail->ID, '_wp_attachment_image_alt', true ) ){ 
        $img_desc  = 'role="img" aria-label="'.get_post_meta($thumbnail->ID, '_wp_attachment_image_alt', true ).'"';
        }	else {
        $img_desc  = '';
      };

      $image_url = get_the_post_thumbnail_url();
      $image_bg = 'style="background-image:url('.$image_url.'); '.$img_focus.';"';
      }

      // If not image, Default image

      else {
      $thumbnail = '';
      $img_desc = '';
      $img_focus = 'background-position:'.get_field("image_focal_point", $default_image_ID);
      $image_url = $default_image;
      $image_bg = 'style="background-image:url('.$image_url.'); '.$img_focus.';"';
      }

    ?>

    <div class="nbanner">
      <div class="nbanner_image" <?php echo $image_bg.' '.$img_desc;?>></div>
        <div class="nbanner_content ncontain">
        <?php get_template_part('blocks/blks/banner_headings');?>
        <?php echo nc_inner_blocks(); ?>
      </div>
    </div>

    <?php elseif( !is_page_template( 'blank' ) && !is_author() && !$show ) :?>

    <div class="maintitle">
      <div class="ncontain">
        <?php get_template_part('blocks/blks/banner_headings');?>
        <?php echo nc_inner_blocks(); ?>
      </div>
    </div>

    <?php endif;?>    
	

<?php
}

?>