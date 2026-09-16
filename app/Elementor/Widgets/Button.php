<?php
//phpcs:disable
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\NayarCore\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use RT\NayarCore\Abstracts\ElementorBase;
use RT\NayarCore\Helper\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Button extends ElementorBase {

	public function __construct( $data = [], $args = null ) {
		$this->rt_name = esc_html__( 'RT Button', 'nayar-core' );
		$this->rt_base = 'rt-button';
		parent::__construct( $data, $args );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'sec_general',
			[
				'label' => esc_html__( 'General', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'       => esc_html__( 'Button Style', 'nayar-core' ),
				'type'        => Controls_Manager::SELECT2,
				'options'   => [
					'1' => __( 'Button 01', 'nayar-core' ),
					'2' => __( 'Button 02', 'nayar-core' ),
				],
				'default'     => '1',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'nayar-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'See More',
			]
		);

		$this->add_control(
			'link',
			[
				'label'         => __( 'Button Link', 'nayar-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'nayar-core' ),
				'show_external' => true,
				'dynamic'       => [
					'active' => true,
				],
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);
		$this->add_responsive_control(
			'alignment',
			[
				'label'     => __( 'Alignment', 'nayar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'nayar-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'nayar-core' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'nayar-core' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-button' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();

		// Button Settings
		$this->start_controls_section(
			'button_settings',
			[
				'label' => esc_html__( 'Button Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typo',
				'label'    => esc_html__( 'Typography', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .rt-button .rt-primary-btn',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'              => __( 'Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'button_radius',
			[
				'label'              => __( 'Radius', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_width',
			[
				'type'    => Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Width', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_max_width',
			[
				'type'    => Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Width', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_height',
			[
				'type'    => Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Height', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-button-1' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rt-button .btn' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		//Button style Tabs
		$this->start_controls_tabs(
			'button_style_tabs', [
			]
		);

		$this->start_controls_tab(
			'button_style_normal_tab',
			[
				'label' => __( 'Normal', 'nayar-core' ),
			]
		);
		$this->add_control(
			'button_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_bg_color',
				'label' => __('Background', 'nayar-core'),
				'types' => ['classic', 'gradient'],
				'fields_options'  => [
					'background' => [
						'label' => esc_html__( 'Background', 'nayar-core' ),
					],
				],
				'selector' => '{{WRAPPER}} .rt-button .rt-primary-btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .rt-button .rt-primary-btn, {{WRAPPER}} .rt-button .icon-area',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'label' => __('Box Shadow', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-button .rt-primary-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_style_hover_tab',
			[
				'label' => __( 'Hover', 'nayar-core' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-button:hover .rt-primary-btn' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-button:hover .rt-primary-btn i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_bg_hover_color',
				'label' => __('Background', 'nayar-core'),
				'types' => ['classic', 'gradient'],
				'fields_options'  => [
					'background' => [
						'label' => esc_html__( 'Background', 'nayar-core' ),
					],
				],
				'selector' => '{{WRAPPER}} .rt-button:hover .rt-primary-btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_hover_border',
				'selector' => '{{WRAPPER}} .rt-button:hover .rt-primary-btn, {{WRAPPER}} .rt-button:hover .icon-area',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_hover_box_shadow',
				'label' => __('Box Shadow', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-button:hover .rt-primary-btn',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Button Icon
		$this->start_controls_section(
			'icon_settings',
			[
				'label' => esc_html__( 'Icon Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_alignment',
			[
				'label'     => __( 'Alignment', 'nayar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'row'   => [
						'title' => __( 'left', 'nayar-core' ),
						'icon'  => 'eicon-arrow-right',
					],
					'row-reverse'  => [
						'title' => __( 'right', 'nayar-core' ),
						'icon'  => 'eicon-arrow-left',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'            => __( 'Choose Icon', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'icon-rt-arrow-right-1',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'      => __( 'Icon Size', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 40,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-button .rt-primary-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rt-button .rt-primary-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-button i'        => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-button svg path' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .rt-button .rt-primary-btn i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_icon_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon BG Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-button .btn-icon'        => 'background: {{VALUE}}',
					'{{WRAPPER}} .rt-button .icon-area'        => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_icon_hover_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Hover Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-button:hover i'        => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-button:hover svg path' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .rt-button:hover .rt-primary-btn i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_icon_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Hover BG Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-button:hover .btn-icon'        => 'background: {{VALUE}}',
					'{{WRAPPER}} .rt-button:hover .icon-area'        => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
			[
				'type'    => Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Height', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-icon' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .icon-area' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'type'    => Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Width', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-icon' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .icon-area' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_line_height',
			[
				'type'    => Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Line Height', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .icon-area' => 'line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .btn-icon' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'type'    => Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Icon Space', 'nayar-core' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_top_position',
			[
				'type'    => Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Icon Top Position', 'nayar-core' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-button .icon-area' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'button_style' => [ '1' ]
				],
			]
		);

		$this->end_controls_section();

		//Animation setting
		$this->start_controls_section(
			'animation_style',
			[
				'label' => esc_html__( 'Animation Style', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'animation',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Animation', 'nayar-core' ),
				'options' => [
					'wow' => esc_html__( 'On', 'nayar-core' ),
					'wow-off'         => esc_html__( 'Off', 'nayar-core' ),
				],
				'default' => 'wow-off',
			]
		);

		$this->add_control(
			'animation_effect',
			[
				'type'    => Controls_Manager::SELECT,
				'id'      => 'animation_effect',
				'label'   => esc_html__( 'Entrance Animation', 'nayar-core' ),
				'options' => [
					'bounce' => esc_html__( 'bounce', 'nayar-core' ),
					'flash' => esc_html__( 'flash', 'nayar-core' ),
					'pulse' => esc_html__( 'pulse', 'nayar-core' ),
					'headShake' => esc_html__( 'headShake', 'nayar-core' ),
					'swing' => esc_html__( 'swing', 'nayar-core' ),
					'hinge' => esc_html__( 'hinge', 'nayar-core' ),
					'flipInX' => esc_html__( 'flipInX', 'nayar-core' ),
					'flipInY' => esc_html__( 'flipInY', 'nayar-core' ),
					'fadeIn' => esc_html__( 'fadeIn', 'nayar-core' ),
					'fadeInUp' => esc_html__( 'fadeInUp', 'nayar-core' ),
					'fadeInDown' => esc_html__( 'fadeInDown', 'nayar-core' ),
					'fadeInLeft' => esc_html__( 'fadeInLeft', 'nayar-core' ),
					'fadeInRight' => esc_html__( 'fadeInRight', 'nayar-core' ),
					'bounceIn' => esc_html__( 'bounceIn', 'nayar-core' ),
					'bounceInUp' => esc_html__( 'bounceInUp', 'nayar-core' ),
					'bounceInDown' => esc_html__( 'bounceInDown', 'nayar-core' ),
					'bounceInLeft' => esc_html__( 'bounceInLeft', 'nayar-core' ),
					'bounceInRight' => esc_html__( 'bounceInRight', 'nayar-core' ),
					'slideInUp' => esc_html__( 'slideInUp', 'nayar-core' ),
					'slideInDown' => esc_html__( 'slideInDown', 'nayar-core' ),
					'slideInLeft' => esc_html__( 'slideInLeft', 'nayar-core' ),
					'slideInRight' => esc_html__( 'slideInRight', 'nayar-core' ),
					'zoomIn' => esc_html__( 'zoomIn', 'nayar-core' ),
					'zoomInDown' => esc_html__( 'zoomInDown', 'nayar-core' ),
					'zoomInUp' => esc_html__( 'zoomInUp', 'nayar-core' ),
					'zoomInLeft' => esc_html__( 'zoomInLeft', 'nayar-core' ),
					'zoomInRight' => esc_html__( 'zoomInRight', 'nayar-core' ),
					'zoomOut' => esc_html__( 'zoomOut', 'nayar-core' ),
				],
				'default' => 'fadeInUp',
				'condition'   => [
					'animation' => [ 'wow' ]
				],
			]
		);

		$this->add_control(
			'delay',
			[
				'type'    => Controls_Manager::TEXT,
				'label'   => esc_html__( 'Delay', 'nayar-core' ),
				'default' => '200',
				'condition'   => [
					'animation' => [ 'wow' ]
				],
			],
		);

		$this->add_control(
			'duration',
			[
				'type'    => Controls_Manager::TEXT,
				'id'      => 'duration',
				'label'   => esc_html__( 'Duration', 'nayar-core' ),
				'default' => '1200',
				'condition'   => [
					'animation' => [ 'wow' ]
				],
			],
		);

		$this->end_controls_section();

	}

	protected function render() {
		$data     = $this->get_settings();
		$template = 'view-1';
		Fns::get_template( "elementor/button/$template", $data );
	}

}