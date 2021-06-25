<div class="column-item post-style-2">
    <div class="post-inner">

		<?php if (has_post_thumbnail() && '' !== get_the_post_thumbnail()) : ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php
						$blog_style = freshio_get_theme_option('blog-style');

						if ($blog_style == 'masonry') {
							if (is_home() || is_archive()) {
								the_post_thumbnail();
							} else {
								the_post_thumbnail('freshio-post-grid');
							}
						}else{
							the_post_thumbnail('freshio-post-grid');
						}
					?>
				</a>
				<?php freshio_categories_link();?>
			</div><!-- .post-thumbnail -->
		<?php else: ?>
			<?php freshio_categories_link();?>
		<?php endif;?>

        <div class="entry-header">

			<div class="entry-meta">
				<?php
				freshio_post_meta();
				?>
			</div>

			<?php
			the_title(sprintf('<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');
			?>

			<?php if (is_archive() || is_home()):?>
			<div class="entry-content">
				<p> <?php echo  wp_trim_words(get_the_excerpt(), 20); ?> </p>
			</div>
			<?php endif;?>
        </div>
    </div>
</div>
