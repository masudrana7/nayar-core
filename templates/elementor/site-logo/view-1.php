<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $logo_mode         string
 */
global $logo_has_used;
$logo_h1    = ! is_singular( [ 'post' ] );
$site_title = $logo_title ?? '';
if ( isset( $logo_has_used ) && $logo_has_used ) {
	$logo_h1 = '';
}
?>
    <div class="site-branding <?php echo esc_attr($logo_mode); ?>">
		<?php echo wp_kses_post( nayar_site_logo( $logo_h1, $site_title, $logo_mode ) ); ?>
    </div>
<?php
$logo_has_used = true;
