<?php
$boxed_container = freshio_get_theme_option('boxed-container', 1400);
$boxed_offset_top    = freshio_get_theme_option('offset-top', 30);
$boxed_offset_bottom    = freshio_get_theme_option('offset-bottom', 30);
$boxed_border_radius   = freshio_get_theme_option('border-radius-body', 5);

$layoutcss = 'body.freshio-layout-boxed{max-width:' . $boxed_container . 'px;}';
$layoutcss .= '@media(min-width: ' . $boxed_container . 'px){ body.freshio-layout-boxed { margin-top:' . $boxed_offset_top . 'px; margin-bottom: ' . $boxed_offset_bottom . 'px; border-radius: ' . $boxed_border_radius . 'px;}}';
$layoutcss .= '@media(min-width: ' . $boxed_container . 'px){body.freshio-layout-boxed .header-4 .header-main{border-radius: '. $boxed_border_radius .'px ' . $boxed_border_radius .'px 0 0px;}}';
$cssCode .= <<<CSS
$layoutcss
CSS;


return $cssCode;
