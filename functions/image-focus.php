<?php

// For featured images in page banners and thumbnail archives
function nc_image_focus() {

  if( function_exists('get_field') && get_field("image_focal_point", true) ){ 
    
    $img_focus = get_field("image_focal_point", true);

    return 'background-position:'.$img_focus.'; transform-origin:'.$img_focus.';'; 
  }
  else {
    return 'background-position:50% 50%; transform-origin:50% 50%;';	
  }

}
?>