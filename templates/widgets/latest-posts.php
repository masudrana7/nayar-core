<?php
//phpcs:disable
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use RT\Nayar\Helpers\Fns;
$post_classes = 'rt-blog-post';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>
    <div class="article-inner-wrapper">
	    <?php if ( !empty( has_post_thumbnail() )) { ?>
        <div class="post-thumbnail-wrap">
            <figure class="post-thumbnail">
                <a class="post-thumb-link alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php the_post_thumbnail( 'nayar-size2' ); ?></a>
            </figure><!-- .post-thumbnail -->

	        <?php $rt_youtube_link = get_post_meta( get_the_ID(), 'rt_youtube_link', true );
	        if ( nayar_option( 'rt_video_visibility' ) == 1 && ( 'video' == get_post_format( get_the_ID() ) ) && !empty( $rt_youtube_link ) ) { ?>
                <div class="rt-video"><a class="popup-youtube video-popup-icon" href="<?php echo esc_url( $rt_youtube_link );?>"><i class="icon-rt-play"></i></a></div>
	        <?php } ?>
        </div>
	    <?php } ?>
        <div class="entry-wrapper">
				<?php
				if ( ! empty( $meta_list ) ) {
					echo wp_kses_post( nayar_post_meta( [
						'with_list'     => true,
						'include'       => $meta_list,
					] ) );
				}
				the_title( sprintf( '<h4 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h4>' );
				?>

			<?php
            if( $content ):
				echo "<div class='entry-content'>";
				echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) );
				echo "</div>";
                endif;
			?>
        </div>
    </div>
</article>