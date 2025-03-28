<?php

// Register Theme Scripts and CSS

function nc_register_assets(){

  /* Javascript */

  wp_register_script('wp-menu-support', get_theme_file_uri('/assets/js/menus.js'), array('jquery'), null, true);
  wp_enqueue_script('wp-menu-support');

  /* CSS */

  wp_register_style('nc-icons', get_theme_file_uri('/assets/icons/style.css'));
  wp_enqueue_style('nc-icons');

  wp_register_style('nc-vars', get_theme_file_uri('/assets/css/variables.css'));
  wp_enqueue_style('nc-vars');

  wp_register_style('nc-uclasses', get_theme_file_uri('/assets/css/uclasses.css'), array('nc-vars'));
  wp_enqueue_style('nc-uclasses');

  wp_register_style('nc-reset', get_theme_file_uri('/assets/css/reset.css'), array('nc-vars'));
  wp_enqueue_style('nc-reset');

  wp_register_style('nc-blocks', get_theme_file_uri('/assets/css/wpblocks.css'), array('nc-reset'));
  wp_enqueue_style('nc-blocks');

  wp_register_style('nc-content', get_theme_file_uri('/assets/css/content.css'), array('nc-blocks'));
  wp_enqueue_style('nc-content');

  wp_register_style('nc-theme', get_theme_file_uri('/assets/css/theme.css'), array('nc-content'));
  wp_enqueue_style('nc-theme');

}

add_action('wp_enqueue_scripts', 'nc_register_assets');



// Load Editor Styles

add_theme_support('editor-styles');

add_editor_style( 
  array( 
    '/assets/css/editor.css',
    '/assets/css/variables.css',
    '/assets/css/uclasses.css',
    '/assets/css/wpblocks.css',
    '/assets/css/content.css',
    '/assets/icons/style.css'
  ) 
);