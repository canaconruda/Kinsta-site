<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Opal  Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2017 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
/**
 * Enable/distable share box
 */
$default = '<span class="social-share-title">' . esc_html__( 'Share:', 'freshio' ) . '</span>';
$heading = apply_filters( 'freshio_social_heading', $default );
if ( freshio_get_theme_option( 'social-share', true ) ) {
	?>
    <div class="freshio-social-share">
		<?php if (!is_singular('post')):?>
		<?php echo '<span class="social-share-header">' . wp_kses_post( $heading ) . '</span>'; ?>
		<?php endif;?>
		<?php if ( freshio_get_theme_option( 'social-share-facebook', true ) ): ?>
            <a class="social-facebook"
               href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&display=page"
               target="_blank" title="<?php esc_html_e( 'Share on facebook', 'freshio' ); ?>">
                <i class="freshio-icon-facebook"></i>
                <span><?php esc_html_e( 'Facebook', 'freshio' ); ?></span>
            </a>
		<?php endif; ?>

		<?php if ( freshio_get_theme_option( 'social-share-twitter', true ) ): ?>
            <a class="social-twitter"
               href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" target="_blank"
               title="<?php esc_html_e( 'Share on Twitter', 'freshio' ); ?>">
                <i class="freshio-icon-twitter"></i>
                <span><?php esc_html_e( 'Twitter', 'freshio' ); ?></span>
            </a>
		<?php endif; ?>

		<?php if ( freshio_get_theme_option( 'social-share-linkedin', true ) ): ?>
            <a class="social-linkedin"
               href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>"
               target="_blank" title="<?php esc_html_e( 'Share on LinkedIn', 'freshio' ); ?>">
                <i class="freshio-icon-linkedin"></i>
                <span><?php esc_html_e( 'Linkedin', 'freshio' ); ?></span>
            </a>
		<?php endif; ?>

		<?php if ( freshio_get_theme_option( 'social-share-google-plus', true ) ): ?>
            <a class="social-google" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank"
               title="<?php esc_html_e( 'Share on Google plus', 'freshio' ); ?>">
                <i class="freshio-icon-google-plus"></i>
                <span><?php esc_html_e( 'Google+', 'freshio' ); ?></span>
            </a>
		<?php endif; ?>

		<?php if ( freshio_get_theme_option( 'social-share-pinterest', true ) ): ?>
            <a class="social-pinterest"
               href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink() ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>&amp;; ?>"
               target="_blank" title="<?php esc_html_e( 'Share on Pinterest', 'freshio' ); ?>">
                <i class="freshio-icon-pinterest-p"></i>
                <span><?php esc_html_e( 'Pinterest', 'freshio' ); ?></span>
            </a>
		<?php endif; ?>

		<?php if ( freshio_get_theme_option( 'social-share-email', true ) ): ?>
            <a class="social-envelope" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>"
               title="<?php esc_html_e( 'Email to a Friend', 'freshio' ); ?>">
                <i class="freshio-icon-envelope"></i>
                <span><?php esc_html_e( 'Email', 'freshio' ); ?></span>
            </a>
		<?php endif; ?>
    </div>
	<?php
}
?>
