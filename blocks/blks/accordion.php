<?php

// New Block
add_action('acf/init', 'nc_accordion_block');
function nc_accordion_block() {

        // register a items block
        acf_register_block_type(array(
            'name'              => 'nc_accordion',
            'title'             => __('NC Accordion', 'nc-block-theme'),
            'description'       => __('Title, content and links.', 'nc-block-theme'),
            'render_callback'   => 'nc_accordion_block_markup',
						'category'          => 'common',
            'icon'              => get_nc_icon('nc-block'),
            'mode'              => 'preview',
            'keywords'          => array('accordion', 'details', 'summary', 'faqs', 'answers', 'questions' ),
            'post_types'        => get_post_types(),
            'align'             => 'none',
            'supports'          => array( 
                  'align' => array( 'none','full','wide'), 
                  'mode' => true,
                  'multiple' => true,
									),			
        ));
}

/* This displays the block */

function nc_accordion_block_markup( $block, $content = '', $is_preview = false ) {

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

		$ranum = '_'.rand(100, 500);

	// ACF Block
	
  $select_links = get_field('select_links', false, false);
  $truncate = get_field('tuncate_char_limit') ?: '100';
	$content = get_field('display_content');
	$mobile = get_field('mobile') ?: '600';
	$choose = get_field('choose') /* write or post */;
	$collapse = get_field('collapse');
	$scroll = get_field('scrollview');
	
	if($collapse){
		$closeit = ' name="'.$id.'"';
	}
	else {
		$closeit = null;
	}

?>

	<?php 
	wp_enqueue_style('nc-blocks-accordion');
	?>

	<?php if( $scroll ):?>
	<script id="<?php echo $id; ?>-scroll-js">
		document.addEventListener('DOMContentLoaded', () => {
		// Select all <details> elements that belong to our accordion group
		const detailsElements = document.querySelectorAll('details[<?php echo $closeit; ?>]');

		// Add a 'toggle' event listener to each details element
		detailsElements.forEach(details => {
		details.addEventListener('toggle', () => {
		// Check if the details element is currently being opened (expanded)
		if (details.open) {
		// The CSS transition-duration is 0.5s (500ms).
		// We use a setTimeout slightly longer than the CSS transition
		// to ensure the content has fully expanded and the browser has
		// settled its layout before attempting to scroll.
		// This helps in accurately calculating the element's final position.
		setTimeout(() => {
		// Scroll the opened details element into view
		details.scrollIntoView({
		behavior: 'smooth', // Enables smooth, animated scrolling
		block: 'start'       // Aligns the top of the element with the top of the viewport
		});
		}, 600); // Delay in milliseconds (0.6 seconds)

		}

		// Handle the chevron icon rotation for visual feedback
		// and adjust the summary's border-radius when open/closed.
		const summary = details.querySelector('summary');
		// The icon rotation is now handled purely by CSS using the details[open] selector
		// and a transition on the SVG element itself.
		// The border-radius adjustment is also handled by CSS.
		});
		});
		});
	</script>
	<?php else:?>
		
	<?php endif;?>

	<div id="<?php echo $id; ?>" class="nccordion ncblock<?php echo esc_attr($className); ?>" <?php echo nc_block_attr();?>>
		
			<?php if( $choose == 'post' ):?>

			<?php $args = array(
				'post_type' => 'any',
				'posts_per_page' => -1,
				'post__in' => $select_links,
				'post_status' => 'publish',
				'orderby' => 'post__in',
				'ignore_sticky_posts' => true
      );
			?>

			<?php $queryfaqs = new WP_Query($args); 
			if ( $queryfaqs->have_posts() && $select_links ) : ?>

      <?php while ( $queryfaqs->have_posts() ) : $queryfaqs->the_post(); ?>

			<details class="nccordion_details"<?php echo $closeit; ?>>
				<summary class="nccordion_header" id="faq-<?php the_ID(); ?>" title="<?php echo get_the_title( get_the_ID() );?>"><div class="nccordion_hdcontain"><?php echo get_the_title( get_the_ID() );?></div></summary>  
				<div class="nccordion_content">
					<?php if($content == 'truncate') :?>
					<?php echo substr( get_the_excerpt( get_the_ID() ), 0, $truncate );?><span class="nccordion_ell">&hellip;</span> <a href="<?php echo get_the_permalink( get_the_ID() ); ?>" class="nccordion_rmore"><?php _e('Read more','nc-block-theme');?></a>
					<?php else :?>
					<?php the_content(get_the_ID());?>  
					<?php endif;?>
				</div>
			</details>
      
			<?php endwhile; ?>
			</div>

			 <?php wp_reset_postdata();?>
			 <?php else : ?>
				<div class="nccordion">
					<p><?php _e('No posts have been selected yet. Select some posts to add here or write your own content.','nc-block-theme');?></p>
			 </div>
			<?php endif; // end loop ?>

			<?php elseif( $choose == 'write' && have_rows('custom_content') ):?>

				<?php while( have_rows('custom_content') ): the_row(); 
					$acc_heading = get_sub_field('heading') ?:'Heading';
					$acc_content = get_sub_field('content') ?: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.';
					$acc_open = get_sub_field('open');
				?>
					<details class="nccordion_details <?php echo 'nccordion-'.get_row_index(); ?>"<?php if ($acc_open){ echo' open'; };?><?php echo $closeit; ?>>
						<summary class="nccordion_header"><div class="nccordion_hdcontain"><?php echo $acc_heading; ?></div></summary>  
						<div class="nccordion_content">
							<?php echo $acc_content; ?>
						</div>
					</details>

			<?php endwhile; ?>

			<!-- end container -->

				<?php else : ?>
					<div class="nocontent">
						<p><?php _e('Chose to display posts or write your own content. Use the sidebar settings to begin.','nc-block-theme');?></p>
					</div>
			<?php endif;?>
		</div>

<style id="<?php echo $id; ?>-css">

<?php if( get_field('acc_icon_style') == 'arrow' ):?>
<?php echo '#'.$id; ?>.nccordion {

	.nccordion_header:before {
    content: '\e901';
		transform: rotate(-90deg);
		font-size: 0.7em;
	}

	.nccordion_details[open] .nccordion_header:before {
  	transform: rotate(90deg);
	}
}
<?php endif;?>

</style>


<?php } ?>