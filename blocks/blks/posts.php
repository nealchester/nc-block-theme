<?php

// New Block
add_action('acf/init', 'nc_posts_block');
function nc_posts_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_posts',
            'title'             => __('NC Posts', 'nc-block-theme'),
            'description'       => __('Display the latest posts or select your own to feature.', 'nc-block-theme'),
            'render_callback'   => 'nc_posts_block_markup',
            'category'          => 'layout',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'edit',
            'keywords'          => array('posts', 'latest', 'recent', 'featured' ),
			'post_types'        => get_post_types(),
			'align'             => 'full',
			'supports'          => array( 
				'align' => array( 'full' ), 
				'mode' => true,
				'multiple' => true,
				'jsx' => true,
				),
			));
}

/* This displays the block */

function nc_posts_block_markup( $block, $content = '', $is_preview = false ) {

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
	if(get_field('amount')) { $amount = get_field('amount'); } else { $amount = '7'; };
	if(get_field('offset')) { $offset = get_field('offset'); } else { $offset = '0'; };
	if(get_field('post_type')) { $ptype = get_field('post_type'); } else { $ptype = 'post'; };
	
	$link_type = get_field('link_type');
	$select_links = get_field('select_links', false, false);
	$clayout = get_field('column_layout');
	$cstyle = get_field('column_style');

	$columns = get_field('column_count');
	$bcolumns = get_field('break_columns');
	$cgap = get_field('column_gap');
	$rgap = get_field('row_gap');

	$breaklayout = get_field('breakpoint_layout');

	if (get_field('breakpoint')) { $breakpoint = get_field('breakpoint'); } else { $breakpoint = '640'; }

	$ratio = get_field('thumb_shape');
	$column_min_width = get_field('col_min_width');
	$column_min_width_break = get_field('col_min_width_break');
	$thumb_width = get_field('thumb_width');
	$bpadding = 'var(--u-padding)';
	$position = get_field('position');

	$position_break = get_field('position_break');
	$thumb_width_break = get_field('thumb_width_break');
	$ratio_break = get_field('thumb_shape_break');

	$showthumb = get_field('block_post_meta') && in_array('thumb', get_field('block_post_meta'));

?>

	<?php 
	wp_enqueue_style('nc-blocks-posts'); 
	wp_enqueue_style('nc-blocks-columns'); 
	?>

	<div id="<?php echo $id; ?>" class="ncard_box<?php echo esc_attr($className); ?>" <?php echo nc_block_attr();?>>
		<div class="ncontain" <?php echo nc_animate();?>>
		
		<?php nc_before_content(); ?>
			
			<?php if ($link_type =='selected') { 
					$args = array(
					'post_type' => 'any',
					'posts_per_page' => -1,
					'post__in' => $select_links,
					'post_status' => 'publish',
					'orderby' => 'post__in',
					'ignore_sticky_posts' => true
					);
				}

				else {
					$args = array(
					'post_type' => $ptype,
					'post_status' => 'publish',
					'posts_per_page' => $amount,
					'offset' => $offset,
					'ignore_sticky_posts' => true
					);
				}
			?>

			<?php $querylatest = new WP_Query($args); if ( $querylatest->have_posts() ) : ?>

			<?php $total_items = $querylatest->found_posts; 
				$size = get_field('image_size');
				$i = 1;
			?>

			<div class="ncolumns nc_content_block_main<?php echo ' '.$cstyle.' '.$clayout.' '.$breaklayout.' ncolumns_total-'.$total_items;?>">
			<?php while ( $querylatest->have_posts() ) : $querylatest->the_post();?>

				<div <?php post_class('ncard ncard-'.$i++); ?>>
			
					<?php if( $showthumb && get_the_post_thumbnail(get_the_ID()) ):?>

						<div class="ncard_imgcon">
							<?php echo get_the_post_thumbnail( get_the_ID(), $size, array( "class" => "ncard_img", "style" => nc_block_image_focus(get_the_ID()) ) ); ?>
						</div>

						<?php else:?>

						<div class="ncard_imgcon">
							<img class="ncard_img" src="<?php nc_block_fallback_image(); ?>" alt="default image" />
						</div>

					<?php endif;?>

					<div class="ncard_text">
						<?php 
						do_action('nc_extend_posts_block_meta_before');
						nc_block_posts_meta(); 
						do_action('nc_extend_posts_block_meta_after');
						?>
					</div>

					<a class="ncard_link" href="<?php echo get_permalink(); ?>"></a>
				</div><!-- / ncard -->

			<?php endwhile; ?>
		 	<?php wp_reset_postdata();?>

			</div><!-- / ncolumns -->

			<?php else:?>

				<div class="nocontent">
						<p><?php _e('Chose which posts to display. Use the sidebar settings to begin.','nc-block-theme');?></p>
					</div>
			<?php endif; // end loop ?>

				
		</div><!-- / ncontain -->
	</div><!-- / ncard_box -->

<style id="<?php echo $id; ?>-css">

<?php nc_box_styles($id); ?>

<?php echo '#'.$id; ?> .ncard {
	--card-direction:<?php if($position){ echo $position; } else { echo'row'; } ?>;
	--card-img-ratio:<?php if($ratio){ echo $ratio; } else { echo'16/9'; } ?>;
	--card-img-width: <?php if($thumb_width){ echo $thumb_width.'%'; } else { echo'30%'; } ?>;
}

<?php echo '#'.$id; ?> .ncolumns {
	--count: <?php if($columns) { echo $columns;} else { echo '3'; } ?>;
    --column-gap: <?php if($cgap){ echo $cgap; } else { echo'1.5rem'; } ?>;
    --row-gap: <?php if($rgap){ echo $rgap; } else { echo'1.5rem'; } ?>;
	--bottom-box-padding:<?php echo $bpadding; ?>; /* Bottom padding of the box */
	--min-col-width: <?php if($column_min_width){ echo $column_min_width.'px'; } else { echo'150px'; } ?>;
}

<?php echo '#wpbody #'.$id; ?> .ncard_img {
		height:100%;
	}

/* Responsive */
<?php if($breakpoint && $breaklayout == 'ncolumns-scroll'):?>
@media(max-width:<?php echo $breakpoint; ?>px){

	<?php echo '#'.$id; ?> .ncolumns-scroll {
		display:grid;
		--column-gap:var(--gap);
		--min-col-width: <?php if($column_min_width_break){ echo $column_min_width_break.'px'; } else { echo'250px'; } ?>;
		grid-template-columns: auto;
    grid-auto-flow: column;
		overflow-x:auto;
		overflow-y:hidden;
		overscroll-behavior-inline: contain;
    scroll-snap-type: inline mandatory;
    scroll-padding-inline: var(--gap);
		padding-inline:var(--gap);
		margin-inline: calc(-1 * var(--gap));
		margin-bottom: calc(-1 * <?php echo $bpadding; ?>);
	}

	<?php echo '#'.$id; ?> .ncolumns-scroll > .ncard { 
		min-width:var(--min-col-width);
		margin-bottom:<?php echo $bpadding; ?>;
		scroll-snap-align: start;
	}

	<?php echo '#'.$id; ?> .ncolumns-scroll .ncard_imgcon {
		height: auto;
	}

	<?php echo '#'.$id; ?> .ncard {
	--card-flex-direction:<?php if($position_break){ echo $position_break; } else { echo'row'; } ?>;
	--image-height:<?php if($ratio_break){ echo $ratio_break; } else { echo'16/9'; } ?>;
	--image-width: <?php if($thumb_width_break){ echo $thumb_width_break.'%'; } else { echo'30%'; } ?>;
	}

}

<?php elseif($breakpoint && $breaklayout == 'ncolumns-stack'):?>
@media(max-width:<?php echo $breakpoint; ?>px){
	<?php echo '#'.$id; ?> .ncolumns-stack { grid-template-columns: 1fr; }
	<?php echo '#'.$id; ?> .ncolumns-mason { --count: 1; --min-col-width:0; }

	<?php echo '#'.$id; ?> .ncard {
	--card-flex-direction:<?php if($position_break){ echo $position_break; } else { echo'row'; } ?>;
	--image-height:<?php if($ratio_break){ echo $ratio_break; } else { echo'70%'; } ?>;
	--image-width: <?php if($thumb_width_break){ echo $thumb_width_break.'%'; } else { echo'30%'; } ?>;
	}
}

<?php elseif($breakpoint && $breaklayout == 'ncolumns-grid'):?>
@media(max-width:<?php echo $breakpoint; ?>px){
	<?php echo '#'.$id; ?> .ncolumns-grid,
	<?php echo '#'.$id; ?> .ncolumns-mason { 
		--min-col-width:0; 
		grid-template-columns: repeat(<?php if($bcolumns) { echo $bcolumns;} else { echo '2'; } ?>,1fr);
		--count: <?php if($bcolumns) { echo $bcolumns;} else { echo '2'; } ?>;
	}
	<?php echo '#'.$id; ?> .ncard {
	--card-flex-direction:<?php if($position_break){ echo $position_break; } else { echo'row'; } ?>;
	--image-height:<?php if($ratio_break){ echo $ratio_break; } else { echo'70%'; } ?>;
	--image-width: <?php if($thumb_width_break){ echo $thumb_width_break.'%'; } else { echo'30%'; } ?>;
	}	

}
<?php endif;?>

<?php nc_block_custom_css(); ?>

</style>
    <?php
}
?>