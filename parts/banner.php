<?php 
// Variables and Conditions

if ( function_exists('get_field') && has_post_thumbnail() && is_home() ) {
  $thumbnail = get_option( 'page_for_posts' );

  if ( get_field("horizontal", $thumbnail) && get_field("vertical", $thumbnail) ) {
    $positions = 'background-position:'.get_field("horizontal", $thumbnail).'% '.get_field("vertical", $thumbnail).'%';
    }
    else {
    $positions = 'background-position:50% 50%';
  };

  $img_desc  = '';	
  $image_url = get_the_post_thumbnail_url($thumbnail);
  $image_bg = 'style="background-image:url('.$image_url.'); '.$positions.'"';
}

elseif ( has_post_thumbnail() && !is_home() && is_singular() ) {
  $thumbnail = get_post( get_post_thumbnail_id() );
  
  if( get_post_meta($thumbnail->ID, '_wp_attachment_image_alt', true ) ){ 
    $img_desc  = 'role="img" aria-label="'.get_post_meta($thumbnail->ID, '_wp_attachment_image_alt', true ).'"';
    }	else {
    $img_desc  = '';
  };

  $image_url = get_the_post_thumbnail_url();
  $image_bg = 'style="background-image:url('.$image_url.'); '.nc_featured_image_focus().'"';
}

else {
  $thumbnail = '';
  $img_desc = '';
  $image_url = nc_fallback_banner_image();
  $image_bg = 'style="background-image:url('.$image_url.'); '.nc_featured_image_focus().'"';
}

?>

<div class="banner">
  <div class="banner_image" <?php echo $image_bg.' '.$img_desc;?>></div>
  <div class="banner_content ncontain">
    <?php get_template_part('parts/headings');?>
  </div>
</div>

<style>
/* Banner Image */

.banner {
  position: relative; 
  background: #000;
  --banner-opacity: 0.6;
}

.banner_content {
  position: relative;
  z-index: 2;
  color: #fff;
  min-height: var(--banner-height, 350px);
  padding-block: 3rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.banner_content > :last-child {
  margin-bottom: 0;
}

.banner_image {
  background-size: cover;
  background-repeat: no-repeat;
  position:absolute;
  z-index:1;
  left:0; right:0; top:0; bottom:0;
  opacity: var(--banner-opacity);

  /* Animated Fade In*/
  animation: BannerImagefadeInAnimation ease 1s;
  animation-iteration-count: 1;
  animation-fill-mode: backwards;
  animation-delay: 0.5s;
}

@keyframes BannerImagefadeInAnimation {
  0% { opacity: 0; }
  100% { opacity: var(--banner-opacity);}
}

</style>