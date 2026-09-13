<?php
/**
 * Helpers methods
 * List all your static functions you wish to use globally on your theme
 *
 * @package nayar-core
 */
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'nayar_about_social' ) ) {
	/**
	 * Get about social icon list
	 * @return void
	 */
	function nayar_about_social( $instance ) {
		$icon_style = nayar_option( 'rt_social_icon_style' ) ?? '';
		$html       = '';

		if ( ! empty( $instance['facebook'] ) ) :
			$html .= '<a href="' . esc_url( $instance["facebook"] ) . '" target="_blank" aria-label="social icon">' . nayar_get_svg( 'facebook' . $icon_style ) . '</a>';
		endif; ?>

		<?php if ( ! empty( $instance["twitter"] ) ) :
			$html .= '<a href="' . esc_url( $instance["twitter"] ) . '" target="_blank" aria-label="social icon">' . nayar_get_svg( 'twitter' . $icon_style ) . '</a>';
		endif; ?>

		<?php if ( ! empty( $instance["linkedin"] ) ) :
			$html .= '<a href="' . esc_url( $instance["linkedin"] ) . '" target="_blank" aria-label="social icon">' . nayar_get_svg( 'linkedin' . $icon_style ) . '</a>';
		endif; ?>

		<?php if ( ! empty( $instance["pinterest"] ) ) :
			$html .= '<a href="' . esc_url( $instance["pinterest"] ) . '" target="_blank" aria-label="social icon">' . nayar_get_svg( 'pinterest' . $icon_style ) . '</a>';
		endif; ?>

		<?php if ( ! empty( $instance["instagram"] ) ) :
			$html .= '<a href="' . esc_url( $instance["instagram"] ) . '" target="_blank" aria-label="social icon">' . nayar_get_svg( 'instagram' . $icon_style ) . '</a>';
		endif; ?>

		<?php if ( ! empty( $instance["youtube"] ) ) :
			$html .= '<a href="' . esc_url( $instance["youtube"] ) . '" target="_blank" aria-label="social icon">' . nayar_get_svg( 'youtube' . $icon_style ) . '</a>';
		endif; ?>

		<?php if ( ! empty( $instance["rss"] ) ) :
			$html .= '<a href="' . esc_url( $instance["rss"] ) . '" target="_blank" aria-label="social icon">' . nayar_get_svg( 'rss' . $icon_style ) . '</a>';
		endif; ?>

		<?php if ( ! empty( $instance["tiktok"] ) ) :
			$html .= '<a href="' . esc_url( $instance["tiktok"] ) . '" target="_blank" aria-label="social icon">' . nayar_get_svg( 'tiktok' . $icon_style ) . '</a>';
		endif;
		?>
		<?php if ( $html ) : ?>
            <div class="footer-social">
				<?php echo wp_kses_post( $html ); ?>
            </div>
		<?php endif ?>
		<?php
	}
}

if ( ! function_exists( 'nayar_contact_render' ) ) {
	function nayar_contact_render( $instance ) {
		ob_start();
		?>
        <div class="nayar-contact-widget-wrapper">
			<?php if ( ! empty( $instance['logo'] ) ) { ?>
                <div class="footer-widget-logo">
					<?php echo wp_get_attachment_image( $instance['logo'], 'full' ); ?>
                </div>
			<?php } ?>
            <ul>
				<?php if ( ! empty( $instance['address'] ) ) : ?>
                    <li>
                        <p><?php echo esc_html( $instance['address'] ); ?></p>
                    </li>
				<?php endif; ?>

				<?php if ( ! empty( $instance['phone'] ) ) : ?>
                    <li class="phone-no"><p><a target="_blank"
                                               href="tel:<?php echo esc_attr( $instance['phone'] ); ?>"><?php echo esc_html( $instance['phone'] ); ?></a>
                        </p>
                    </li>
				<?php endif; ?>

				<?php if ( ! empty( $instance['mail'] ) ) : ?>
                    <li><p><a target="_blank"
                              href="mailto:<?php echo esc_html( $instance['mail'] ); ?>"><?php echo esc_html( $instance['mail'] ); ?></a>
                        </p>
                    </li>
				<?php endif; ?>

				<?php if ( ! empty( $instance['website'] ) ) : ?>
                    <li><p><a target="_blank"
                              href="<?php echo esc_url( $instance['website'] ); ?>"><?php echo esc_html( $instance['website'] ); ?></a>
                        </p>
                    </li>
				<?php endif; ?>
            </ul>
        </div>
		<?php
		return ob_get_clean();
	}
}

//Custom post category list

function rt_all_posts( $post_type ) {
	global $post;
	$type  = $post_type ? $post_type : 'post';
	$args  = [ 'numberposts' => - 1, 'post_type' => $type, ];
	$posts = get_posts( $args );

	$categories = [];

	foreach ( $posts as $pn_cat ) {
		$categories[ $pn_cat->ID ] = get_the_title( $pn_cat->ID );
	}

	return $categories;
}

function rt_taxonomy_post( $taxonomy = 'category' ) {
	$categories = get_categories( [ 'taxonomy' => $taxonomy ] );

	if ( empty( $categories ) ) {
		return;
	}

	$category_dropdown = [];

	foreach ( $categories as $category ) {
		$category_dropdown[ $category->term_id ] = $category->name;
	}

	return $category_dropdown;
}

//post category list
function rt_category_list() {
	$categories = get_categories( [ 'hide_empty' => false ] );
	$lists      = [];
	foreach ( $categories as $category ) {
		$lists[ $category->cat_ID ] = $category->name;
	}

	return $lists;
}


// post tags lists
function rt_tag_list() {
	$tags     = get_tags( [ 'hide_empty' => false ] );
	$tag_list = [];
	foreach ( $tags as $tag ) {
		$tag_list[ $tag->slug ] = $tag->name;
	}

	return $tag_list;
}

//Get all thumbnail size
function rt_get_all_image_sizes() {
	global $_wp_additional_image_sizes;
	$image_sizes = [ '0' => __( 'Default Image Size', 'nayar-core' ) ];
	foreach ( $_wp_additional_image_sizes as $index => $item ) {
		$image_sizes[ $index ] = ucwords( $index . ' - ' . $item['width'] . 'x' . $item['height'] );
	}
	$image_sizes['full'] = __( "Full Size", 'nayar-core' );

	return $image_sizes;
}