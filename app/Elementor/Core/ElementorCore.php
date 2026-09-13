<?php
//phpcs:disable
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\NayarCore\Elementor\Core;

use Elementor\Controls_Manager;

use RT\NayarCore\Traits\SingletonTraits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class ElementorCore {
	use SingletonTraits;

	public function __construct() {
		add_action( 'elementor/frontend/section/before_render', [ $this, 'render_elementor_section_parallax_background' ] );
		add_action( 'elementor/element/section/section_background/before_section_end', [ $this, 'add_elementor_section_background_controls' ] );
		add_action( 'elementor/element/container/section_background/before_section_end', [ $this, 'add_elementor_container_background_controls' ], 10, 2 );
	}

	public function get_bg_controlls( $element ) {
			$element->add_control(
				'rt_container_parallax',
				[
					'label'        => __( 'Parallax', 'nayar-core' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_off'    => __( 'Off', 'nayar-core' ),
					'label_on'     => __( 'On', 'nayar-core' ),
					'default'      => 'no',
					'prefix_class' => 'rt-parallax-bg-',
				]
			);

			$element->add_control(
				'rt_parallax_speed',
				[
					'label'     => __( 'Speed', 'nayar-core' ),
					'type'      => \Elementor\Controls_Manager::NUMBER,
					'min'       => 0.1,
					'max'       => 5,
					'step'      => 0.1,
					'default'   => 0.5,
					'condition' => [
						'rt_container_parallax' => 'yes',
					],
				]
			);

			$element->add_control(
				'rt_parallax_transition',
				[
					'label'        => __( 'Parallax Transition off?', 'nayar-core' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_off'    => __( 'on', 'nayar-core' ),
					'label_on'     => __( 'Off', 'nayar-core' ),
					'default'      => 'off',
					'return_value' => 'off',
					'prefix_class' => 'rt-parallax-transition-',
					'condition'    => [
						'rt_container_parallax' => 'yes',
					],
				]
			);
		}

	function add_elementor_container_background_controls( $element ) {
		// Ensure it's the correct element type
		if ( 'container' === $element->get_name() ) {
			$this->get_bg_controlls( $element );
		}
	}

	function add_elementor_section_background_controls( \Elementor\Element_Section $section ) {
		$this->get_bg_controlls( $section );
	}

	// Render section background parallax
	function render_elementor_section_parallax_background( \Elementor\Element_Base $element ) {
		if ( 'section' === $element->get_name() ) {
			if ( 'yes' === $element->get_settings_for_display( 'rt_section_parallax' ) ) {
				$rt_background = $element->get_settings_for_display( 'background_image' );
				if ( ! isset( $rt_background ) ) {
					return;
				}
				$rt_background_URL = $rt_background['url'];
				$data_speed        = $element->get_settings_for_display( 'rt_parallax_speed' );

				$element->add_render_attribute( '_wrapper', [
					'data-speed'    => $data_speed,
					'data-bg-image' => $rt_background_URL,
				] );
			}
		}
	}

}