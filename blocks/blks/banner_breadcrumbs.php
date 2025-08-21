<?php if ( function_exists('yoast_breadcrumb') && is_singular() && !is_attachment() ):?>
  
<?php yoast_breadcrumb('<nav id="breadcrumbs" class="yoast-breadcrumbs">','</nav>');?>

<?php elseif( is_archive() || is_post_type_archive() || is_home() || is_search() ):?>

<!-- No Breadcrumbes for these pages -->

<?php elseif( is_admin() ):?>

<nav id="breadcrumbs" class="yoast-breadcrumbs">
  <span>
    <span><a href="#null" style="text-decoration:none;">Breadcrumbs</a></span> 
    <span class="ncicon nc-arrow-forward seper"></span> 
    <span class="breadcrumb_last" aria-current="page">Breadcrumb Page Name</span>
  </span>
</nav>

<?php endif; ?>