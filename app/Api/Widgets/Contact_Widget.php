<?php
//phpcs:disable
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\NayarCore\Api\Widgets;

use \WP_Widget;
use \RT_Widget_Fields;

class Contact_Widget extends WP_Widget {

	public function __construct() {
		$id    = NAYAR_CORE_PREFIX . '_contact';
		$title = __( 'Nayar: Contact', 'nayar-core' );
		$args  = [
			'description' => esc_html__( 'Displays Contact Info', 'nayar-core' )
		];
		parent::__construct( $id, $title, $args );
	}


	public function form( $instance ) {
		$defaults = [
			'address' => nayar_option( 'rt_contact_address' ),
			'mail'    => nayar_option( 'rt_email' ),
			'phone'   => nayar_option( 'rt_phone' ),
			'website' => nayar_option( 'rt_website' ),
			'logo'        => '',
			'facebook'    => '',
			'twitter'     => '',
			'linkedin'    => '',
			'pinterest'   => '',
			'instagram'   => '',
			'youtube'     => '',
			'rss'         => '',
			'tiktok'      => '',
			'shortcode'   => '',
		];

		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = [
			'title'   => [
				'label' => esc_html__( 'Title', 'nayar-core' ),
				'type'  => 'text',
			],
			'logo'        => [
				'label' => esc_html__( 'Logo', 'nayar-core' ),
				'type'  => 'image',
				'desc'  => esc_html__( 'Conditionally display the light or dark logo based on the chosen footer style; refrain from preselecting any logo. ', 'nayar-core' ),
			],
			'address' => [
				'label' => esc_html__( 'Address', 'nayar-core' ),
				'type'  => 'textarea',
			],
			'mail'    => [
				'label' => esc_html__( 'Mail', 'nayar-core' ),
				'type'  => 'text',
			],
			'phone'   => [
				'label' => esc_html__( 'Phone', 'nayar-core' ),
				'type'  => 'text',
			],
			'website' => [
				'label' => esc_html__( 'Website', 'nayar-core' ),
				'type'  => 'text',
			],
			'facebook'    => [
				'label' => esc_html__( 'Facebook URL', 'nayar-core' ),
				'type'  => 'url',
			],
			'twitter'     => [
				'label' => esc_html__( 'Twitter URL', 'nayar-core' ),
				'type'  => 'url',
			],
			'linkedin'    => [
				'label' => esc_html__( 'Linkedin URL', 'nayar-core' ),
				'type'  => 'url',
			],
			'pinterest'   => [
				'label' => esc_html__( 'Pinterest URL', 'nayar-core' ),
				'type'  => 'url',
			],
			'instagram'   => [
				'label' => esc_html__( 'Instagram URL', 'nayar-core' ),
				'type'  => 'url',
			],
			'youtube'     => [
				'label' => esc_html__( 'YouTube URL', 'nayar-core' ),
				'type'  => 'url',
			],
			'rss'         => [
				'label' => esc_html__( 'Rss Feed URL', 'nayar-core' ),
				'type'  => 'url',
			],
			'tiktok'        => [
				'label' => esc_html__( 'TikTok URL', 'nayar-core' ),
				'type'  => 'url',
			],
			'shortcode'    => [
				'label' => esc_html__( 'Input Shortcode', 'nayar-core' ),
				'type'  => 'textarea',
			],
		];

		RT_Widget_Fields::display( $fields, $instance, $this );
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['logo']        = ( ! empty( $new_instance['logo'] ) ) ? sanitize_text_field( $new_instance['logo'] ) : '';
		$instance['address']     = ( ! empty( $new_instance['address'] ) ) ? wp_strip_all_tags( $new_instance['address'] ) : '';
		$instance['mail']        = ( ! empty( $new_instance['mail'] ) ) ? wp_strip_all_tags( $new_instance['mail'] ) : '';
		$instance['phone']       = ( ! empty( $new_instance['phone'] ) ) ? wp_strip_all_tags( $new_instance['phone'] ) : '';
		$instance['website']     = ( ! empty( $new_instance['website'] ) ) ? wp_strip_all_tags( $new_instance['website'] ) : '';
		$instance['facebook']    = ( ! empty( $new_instance['facebook'] ) ) ? sanitize_text_field( $new_instance['facebook'] ) : '';
		$instance['twitter']     = ( ! empty( $new_instance['twitter'] ) ) ? sanitize_text_field( $new_instance['twitter'] ) : '';
		$instance['linkedin']    = ( ! empty( $new_instance['linkedin'] ) ) ? sanitize_text_field( $new_instance['linkedin'] ) : '';
		$instance['pinterest']   = ( ! empty( $new_instance['pinterest'] ) ) ? sanitize_text_field( $new_instance['pinterest'] ) : '';
		$instance['instagram']   = ( ! empty( $new_instance['instagram'] ) ) ? sanitize_text_field( $new_instance['instagram'] ) : '';
		$instance['youtube']     = ( ! empty( $new_instance['youtube'] ) ) ? sanitize_text_field( $new_instance['youtube'] ) : '';
		$instance['rss']         = ( ! empty( $new_instance['rss'] ) ) ? sanitize_text_field( $new_instance['rss'] ) : '';
		$instance['tiktok']      = ( ! empty( $new_instance['tiktok'] ) ) ? sanitize_text_field( $new_instance['tiktok'] ) : '';
		$instance['shortcode']    = ( ! empty( $new_instance['shortcode'] ) ) ? sanitize_text_field( $new_instance['shortcode'] ) : '';

		return $instance;
	}

	public function widget( $args, $instance ) {

		echo wp_kses_post( $args['before_widget'] );
		if ( !empty( $instance['title'] ) ) {
			$html = apply_filters( 'widget_title', $instance['title'] );
			$html = $args['before_title'] . $html .$args['after_title'];
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo nayar_html( $html );
		}
		else {
			$html = '';
		}
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo nayar_contact_render( $instance );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		nayar_about_social( $instance );

		if ( ! empty( $instance['shortcode'] ) ) {
			echo "<div class='footer-shortcode'>";
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo do_shortcode( $instance['shortcode'] );
			echo "</div>";
		}
		echo wp_kses_post( $args['after_widget'] );
	}
}