<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $layout             string
 * @var $image              string
 * @var $video_url          string
 * @var $button_text        string
 * @var $scroll_animation   string
 * @var $range_one          string
 * @var $range_two          string
 * @var $x_range            string
 * @var $y_range            string
 */

$animation_opacity1 = $animation_opacity ?? 30;
$animation_opacity2 = $animation_opacity1 - 10;
$animation_opacity3 = $animation_opacity1 - 20;
$img_url = wp_get_attachment_image_src( $image['id'], 'full' );
$img_bg  = '';
if ( $img_url ) {
	$img_bg = "background-image:url(" . esc_attr( $img_url[0] ) . ")";
}
$range_one = ( $scroll_animation == 'yes' ) ? $range_one : '';
$range_two = ( $scroll_animation == 'yes' ) ? $range_two : '';
?>

<?php if( $layout == 'icon-style1' ) { ?>
<div class="rt-video-icon <?php echo esc_attr( $layout ) ?>" data-parallax='{"<?php echo esc_attr( $x_range );?>" : <?php echo esc_attr( $range_one );?>, "<?php echo esc_attr( $y_range );?>" : <?php echo esc_attr( $range_two );?>}'>
	<div class="video-icon">
		<div class="icon-left">
			<div class="icon-box">
				<a class="popup-youtube video-popup-icon" href="<?php echo esc_url( $video_url ) ?>">
                    <i class="icon-rt-play"></i>
				</a>
			</div>
		</div>
		<?php if ( $button_text ) : ?>
			<div class="icon-right">
				<a class="popup-youtube button-text" href="<?php echo esc_url( $video_url ) ?>">
					<?php echo esc_html( $button_text ) ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php } if( $layout == 'icon-style2' ) { ?>
    <div class="rt-video-icon <?php echo esc_attr( $layout ) ?>" style="<?php echo esc_attr( $img_bg ) ?>" data-parallax='{"<?php echo esc_attr( $x_range );?>" : <?php echo esc_attr( $range_one );?>, "<?php echo esc_attr( $y_range );?>" : <?php echo esc_attr( $range_two );?>}'>
        <div class="video-icon">
            <div class="icon-left">
                <div class="icon-box">
                    <a class="popup-youtube video-popup-icon" href="<?php echo esc_url( $video_url ) ?>">
                        <i class="icon-rt-play"></i>
                    </a>
                </div>
            </div>
			<?php if ( $button_text ) : ?>
                <div class="icon-right">
                    <a class="popup-youtube button-text" href="<?php echo esc_url( $video_url ) ?>">
						<?php echo esc_html( $button_text ) ?>
                    </a>
                </div>
			<?php endif; ?>
        </div>
    </div>
<?php } ?>
