<?php
//phpcs:disable
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nayar
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

</div><!-- #content -->

<?php do_action( 'rt_hf_footer_markup' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
