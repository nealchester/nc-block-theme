<?php // Variable 
$authorlink = get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta('user_nicename') );
?>

<div class="postmeta">
	<div class="postmeta_container">
		<div class="postmeta_avatar">
			<?php echo get_avatar ( get_the_author_meta('user_email'), 100 ); ?>
		</div>
		<div class="postmeta_content">
			<div class="postmeta_name" itemprop="author" itemscope="" itemtype="http://schema.org/Person"><?php _e('By','nc-framework');?> <a itemprop="name" rel="author" href="<?php echo esc_url($authorlink) ?>"><?php the_author(); ?></a></div> 
			<span class="postmeta_pubdate nowrap" itemprop="datePublished"><?php the_date(); ?></span>
			<span class="postmeta_update nowrap hide" itemprop="dateModified"><?php the_modified_date(); ?></span>
		</div>	
	</div>
</div>