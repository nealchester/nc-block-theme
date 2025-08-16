<?php

// New Block
add_action('acf/init', 'nc_sharing_block');
function nc_sharing_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_sharing',
            'title'             => __('NC Sharing Block', 'nc-block-theme'),
            'description'       => __('An svg image to divide sections', 'nc-block-theme'),
            'render_callback'   => 'nc_sharing_block_markup',
            'category'          => 'common',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'preview',
            'keywords'          => array('divider'),
			'post_types'        => get_post_types(),
			'align'             => 'none',
			'supports'          => array( 
									'align' => array( 'full' ), 
									'mode' => true,
									'multiple' => false,
									),
        ));
}

/* This displays the block */

function nc_sharing_block_markup( $block, $content = '', $is_preview = false ) {

	// ID Setup
	if (get_field('set_id')) { $id = get_field('set_id'); } else { $id = uniqid("divider_"); };

    // Create class attribute allowing for custom "className" and "align" values.
    $className = '';
    if( !empty($block['className']) ) {
        $className .= ' ' . $block['className'];
    }
    if( !empty($block['align']) ) {
        $className .= ' align' . $block['align'];
    }

	//ACF Block

    $siteurl = get_permalink(get_the_ID());
    $sitetitle = get_the_title(get_the_ID());
    $share_on = __('Share on', 'nc-block-theme');

    $share = get_field('share_icons');
    $brandcolors = get_field('brand_colors');
    if ($brandcolors) {
        $bclrs = ' show-brand-colors';
    }
    else { $bclrs = null; }

?>
	<?php 
	wp_enqueue_style('nc-blocks-social'); 
	?>

    <div class="sharelinks_container<?php echo esc_attr($className); ?>">
    <div class="sharelinks<?php echo $bclrs; ?>">

    <?php if( $share && in_array('facebook', $share) ) :?>

    <a class="sharelinks_anchor brand-facebook" href="https://www.facebook.com/sharer.php?u=<?php echo $siteurl; ?>" target="_blank" rel="nofollow" title="<?php echo $share_on;?> FaceBook">
        <span class="ncicon nc-facebook"></span>
    </a>

    <?php endif;?>

    <?php if( $share && in_array('twitter', $share) ) :?>

    <a class="sharelinks_anchor brand-twitter" href="https://x.com/intent/tweet?url=<?php echo $siteurl; ?>&text=<?php echo $sitetitle; ?>&via=" target="_blank" rel="nofollow" title="<?php echo $share_on;?> X (formerly know as Twitter)">
        <span class="ncicon nc-twitter"></span>
    </a>

    <?php endif;?>

    <?php if( $share && in_array('pinterest', $share) ) :?>

    <a class="sharelinks_anchor brand-pinterest" href="https://www.pinterest.com/pin/create/button?url=<?php echo $siteurl; ?>&media=&description=<?php echo $sitetitle; ?>" target="_blank" rel="nofollow" title="<?php echo $share_on;?> Pinterest">
        <span class="ncicon nc-pinterest"></span>
    </a>

    <?php endif;?>

    <?php if( $share && in_array('linkedin', $share) ) :?>

    <a class="sharelinks_anchor brand-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo str_replace(':','%3A', $siteurl); ?>&title=<?php echo $sitetitle; ?>&summary=&source=" target="_blank" rel="nofollow" title="<?php echo $share_on;?> LinkedIn">
    <span class="ncicon nc-linkedin"></span>
    </a>

    <?php endif;?>

    <?php if( $share && in_array('pocket', $share) ) :?>

    <a class="sharelinks_anchor brand-pocket" href="https://getpocket.com/save?url=<?php echo str_replace(':','%3A', $siteurl); ?>&title=<?php echo $sitetitle; ?>" target="_blank" rel="nofollow" title="<?php _e('Save to Pocket','nc-framework');?>">
    <span class="ncicon nc-get-pocket"></span>
    </a>

    <?php endif;?>

    <?php if( $share && in_array('reddit', $share) ) :?>

    <a class="sharelinks_anchor brand-reddit" href="https://reddit.com/submit?url=<?php echo str_replace(':','%3A', $siteurl); ?>&title=<?php echo $sitetitle; ?>" target="_blank" rel="nofollow" title="<?php echo $share_on;?> Reddit">
    <span class="ncicon nc-reddit"></span>
    </a>

    <?php endif;?>

    <?php if( $share && in_array('email', $share) ) :?>    

    <a class="sharelinks_anchor brand-email" href="mailto:%7Bemail_address%7D?subject=<?php echo $sitetitle; ?>&body=<?php echo $siteurl; ?>%20" target="_blank" rel="nofollow" title="<?php _e('Share via Email','nc-framework');?>">
    <span class="ncicon nc-envelope"></span>
    </a>

    <?php endif;?>

    </div>
    </div>

<?php } ?>