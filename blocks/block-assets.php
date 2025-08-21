<?php

function load_animation_css() {?>

<?php $animate_css = get_theme_file_uri('/blocks/js/animate/aos.css'); ?>

<script async>
  /* Load CSS and check if a link with this ID already 
    exists to prevent duplicate loading
  */
  if (!document.getElementById('nc-blocks-animate-css')) {
      // Create a new <link> element
      var link = document.createElement('link');

      // Set its attributes
      link.rel = 'stylesheet';
      link.type = 'text/css';
      link.href = '<?php echo esc_url( $animate_css ); ?>'; // Replace with your file name
      link.id = 'nc-blocks-animate-css'; // Optional but good practice for checking

      // Append the link element to the <head> of the document
      document.head.appendChild(link);
  }
</script>

<?php }

add_action('wp_footer', 'load_animation_css');

/* Register CSS and JS */

function nc_blocks_register_assets(){
  
  // Register and equeue Scroll Animation //
  
      // Scroll script  
      wp_register_script('nc-blocks-animate', 
        get_theme_file_uri('/blocks/js/animate/aos.js'), 
        null, 
        array(
          'strategy' => 'async',
          'in_footer' => true
        )
      );
      wp_enqueue_script('nc-blocks-animate');


      // Initialize
      wp_register_script('nc-blocks-animate-init', 
        get_theme_file_uri('/blocks/js/animate/aos-init.js'), 
        array('nc-blocks-animate'), null,
        array(
          'strategy' => 'async',
          'in_footer' => true
        )
      );
      wp_enqueue_script('nc-blocks-animate-init');

  /* Register each block's CSS */
  wp_register_style('nc-blocks-accordion', get_theme_file_uri('/blocks/css/accordion.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-columns', get_theme_file_uri('/blocks/css/columns.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-divider', get_theme_file_uri('/blocks/css/divider.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-gallery', get_theme_file_uri('/blocks/css/gallery.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-gradient', get_theme_file_uri('/blocks/css/gradient.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-hero', get_theme_file_uri('/blocks/css/hero.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-list', get_theme_file_uri('/blocks/css/list.css'), array('nc-uclasses'));

  wp_register_style('nc-blocks-lightbox', get_theme_file_uri('/blocks/css/lightbox.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-magnify', get_theme_file_uri('/blocks/js/popup/magnific.css'), array('nc-uclasses'));

  wp_register_style('nc-blocks-parallax', get_theme_file_uri('/blocks/js/parallax/jarallax.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-posts', get_theme_file_uri('/blocks/css/posts.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-rich-text', get_theme_file_uri('/blocks/css/rich-text.css'), array('nc-uclasses'));
  wp_register_style('nc-blocks-slider', get_theme_file_uri('/blocks/js/slider/splide.css'));

  wp_register_style('nc-blocks-mmenu', get_theme_file_uri('/blocks/css/mmenu.css'));
  wp_register_style('nc-blocks-social', get_theme_file_uri('/blocks/css/social.css'));

  wp_register_style('nc-blocks-bigsearch', get_theme_file_uri('/blocks/css/bigsearch.css'));

  wp_register_style('nc-blocks-banner', get_theme_file_uri('/blocks/css/banner.css'));

  wp_register_style('nc-blocks-search-box', get_theme_file_uri('/blocks/css/search.css'), array('nc-uclasses'));

  /* Register each block's Javascript */

  wp_register_script('nc-blocks-slider', get_theme_file_uri('/blocks/js/slider/splide.js'),
    null, null, array('strategy' => 'async', 'in_footer' => false ));

  wp_register_script('nc-blocks-magnify', get_theme_file_uri('/blocks/js/popup/magnific.js'), 
    array('jquery'), null, array('strategy' => 'async', 'in_footer' => false ));

  wp_register_script('nc-blocks-popup', get_theme_file_uri('/blocks/js/popup/popup-once.js'), 
    array('jquery'), null, array('strategy' => 'async', 'in_footer' => false ));



}
add_action('wp_enqueue_scripts', 'nc_blocks_register_assets');


/* Load CSS styles for each block for the block editor. */
// add_theme_support('editor-styles');
 
function nc_load_blocks_css_for_editor(){
  add_editor_style(
    array( 
      '/blocks/css/accordion.css',
      '/blocks/css/columns.css',
      '/blocks/css/divider.css',
      '/blocks/css/gallery.css',
      '/blocks/css/gradient.css',
      '/blocks/css/hero.css',
      '/blocks/css/list.css',
      '/blocks/css/media.css',
      '/blocks/css/posts.css',
      '/blocks/css/rich-text.css',
      '/blocks/css/search.css',
      '/blocks/css/lightbox.css',
      '/blocks/css/mmenu.css',
      '/blocks/css/social.css',
      '/blocks/css/bigsearch.css',
      '/blocks/css/banner.css',
    )
  );
}
add_action('admin_init', 'nc_load_blocks_css_for_editor');