<?php
//phpcs:disable
/**
 * Booking Service widget.
 *
 * Extends the Radius Booking "Service List" Elementor widget so every control,
 * data source and booking interaction keeps working, while the markup is
 * rendered from a Nayar Core template that the theme can override.
 *
 * This class is only ever loaded when the parent class exists — see
 * RT\NayarCore\Elementor\Integrations\RadiusBooking.
 *
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\NayarCore\Elementor\Widgets;

use Elementor\Controls_Manager;
use RT\NayarCore\Helper\Fns;
use RadiusTheme\RadiusBooking\Elementor\Widgets\ServiceListWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Safety net: this file is only reached through
 * RT\NayarCore\Elementor\Integrations\RadiusBooking, which verifies every
 * dependency first. Should anything else autoload it while Radius Booking or
 * Elementor is deactivated, bail out before the class is declared so PHP never
 * extends a missing class (class_exists() then simply returns false).
 *
 * Elementor is checked first on purpose: the Radius Booking widget class itself
 * extends Elementor\Widget_Base, so it must never be autoloaded while
 * Elementor is deactivated.
 */
if ( ! class_exists( '\\Elementor\\Widget_Base' ) || ! class_exists( '\\RadiusTheme\\RadiusBooking\\Elementor\\Widgets\\ServiceListWidget' ) ) {
	return;
}

class BookingService extends ServiceListWidget {

	/**
	 * Widget name.
	 *
	 * Intentionally identical to the original widget so that:
	 *  - pages already built with the Radius Booking widget keep rendering,
	 *  - Radius Booking still detects the widget on the page and enqueues its
	 *    service list scripts, styles and localized data.
	 *
	 * @var string
	 */
	const WIDGET_NAME = 'rtrb_service_list';

	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return self::WIDGET_NAME;
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Booking Service', 'nayar-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'rdtheme-el-custom';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ NAYAR_CORE_PREFIX . '-widgets', 'radius-booking' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array
	 */
	public function get_keywords() {
		$keywords = parent::get_keywords();

		if ( ! is_array( $keywords ) ) {
			$keywords = [];
		}

		return array_values( array_unique( array_merge( $keywords, [ 'booking service', 'nayar' ] ) ) );
	}

	/**
	 * Register widget controls.
	 *
	 * All original controls are inherited; only the Nayar specific ones are added.
	 *
	 * @return void
	 */
	protected function register_controls() {
		parent::register_controls();
		$this->register_nayar_controls();
	}

	/**
	 * Nayar Core specific controls.
	 *
	 * @return void
	 */
	private function register_nayar_controls() {
		$this->start_controls_section(
			'nayar_booking_service_section',
			[
				'label' => esc_html__( 'Nayar Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'nayar_wrapper_class',
			[
				'label'       => esc_html__( 'Extra Wrapper Class', 'nayar-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'description' => esc_html__( 'Space separated CSS classes added to the Nayar wrapper.', 'nayar-core' ),
			]
		);

		$this->add_responsive_control(
			'nayar_columns',
			[
				'label'          => esc_html__( 'Columns', 'nayar-core' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .nayar-booking-service__inner' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
				'description'    => esc_html__( 'Columns for the Nayar service grid.', 'nayar-core' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * The Radius Booking markup (mount root + data attributes) is produced by the
	 * parent widget so the data contract stays intact, then wrapped by a Nayar
	 * template which the theme can override in `nayar-core/elementor/booking-service/`.
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		ob_start();
		parent::render();
		$booking_markup = ob_get_clean();

		$template = apply_filters( 'nayar_booking_service_template', 'view-1', $settings, $this );
		$template = sanitize_file_name( $template );

		if ( ! $template ) {
			$template = 'view-1';
		}

		Fns::get_template(
			"elementor/booking-service/{$template}",
			[
				'settings'       => $settings,
				'booking_markup' => $booking_markup,
				'wrapper_class'  => $this->get_wrapper_classes( $settings ),
			]
		);
	}

	/**
	 * Build the Nayar wrapper classes.
	 *
	 * @param array $settings Widget settings.
	 *
	 * @return string
	 */
	private function get_wrapper_classes( $settings ) {
		$layout  = ! empty( $settings['layout'] ) ? $settings['layout'] : 'grid';
		$columns = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';

		$classes = [
			'nayar-booking-service',
			'nayar-booking-service--' . sanitize_html_class( $layout ),
			'nayar-booking-service--col-' . sanitize_html_class( $columns ),
		];

		if ( ! empty( $settings['nayar_wrapper_class'] ) ) {
			foreach ( explode( ' ', $settings['nayar_wrapper_class'] ) as $extra_class ) {
				$extra_class = sanitize_html_class( $extra_class );

				if ( $extra_class ) {
					$classes[] = $extra_class;
				}
			}
		}
		$classes = apply_filters( 'nayar_booking_service_wrapper_classes', $classes, $settings, $this );
		return implode( ' ', array_unique( array_filter( $classes ) ) );
	}
}
