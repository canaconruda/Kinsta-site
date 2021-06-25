<?php
$sidebar = apply_filters('freshio_theme_sidebar', '');
if (!$sidebar) {
    return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar($sidebar); ?>
</div><!-- #secondary -->