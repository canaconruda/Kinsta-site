<?php
$breadcrumb_bg_color = freshio_get_post_meta(get_the_ID(), 'freshio_breadcrumb_bg_color');
$breadcrumb_bg_img = freshio_get_post_meta(get_the_ID(), 'freshio_breadcrumb_bg_image');
$breadcrumb_css = '';
if($breadcrumb_bg_color){
	$breadcrumb_css .= 'background-color:' . $breadcrumb_bg_color . ';';
}

if($breadcrumb_bg_img){
	$breadcrumb_css .= 'background-image: url(' . $breadcrumb_bg_img . ');';
}
if($breadcrumb_css){
	$cssCode .= <<<CSS
.freshio-breadcrumb{
	$breadcrumb_css
}
CSS;
}



return $cssCode;
