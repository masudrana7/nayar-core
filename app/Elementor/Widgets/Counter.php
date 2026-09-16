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
use Elementor\Group_Control_Box_Shadow;
use RT\NayarCore\Helper\Fns;
use RT\NayarCore\Abstracts\ElementorBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Counter extends ElementorBase {

	public function __construct( $data = [], $args = null ) {
		$this->rt_name = esc_html__( 'RT Counter', 'nayar-core' );
		$this->rt_base = 'rt-counter';
		parent::__construct( $data, $args );
	}

	public function get_script_depends() {
		return [ 'rt-counterup', 'rt-waypoints' ];
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
			'layout',
			[
				'label'       => esc_html__( 'Counter Layout', 'nayar-core' ),
				'type'        => Controls_Manager::SELECT2,
				'options'   => [
					'layout-1' => __( 'Layout 01', 'nayar-core' ),
					'layout-2' => __( 'Layout 02', 'nayar-core' ),
					'layout-3' => __( 'Layout 03', 'nayar-core' ),
					'layout-4' => __( 'Layout 04', 'nayar-core' ),
					'layout-5' => __( 'Layout 05', 'nayar-core' ),
				],
				'default'     => 'layout-1',
			]
		);

        $this->add_control(
            'counter_image',
            [
                'label'   => __( 'Counter Image', 'nayar-core' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'layout' => ['layout-5'],
                ],
            ]
        );

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'nayar-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Projects Completed', 'nayar-core' ),
			]
		);

		$this->add_control(
			'number',
			[
				'label'       => esc_html__( 'Count Number', 'nayar-core' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 567,
			]
		);

		$this->add_control(
			'unit',
			[
				'label'       => esc_html__( 'Counter Unit', 'nayar-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '',
			]
		);

		$this->add_control(
			'speed',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Counter Speed', 'nayar-core' ),
				'default' => 5000,
				'description' => esc_html__( 'The total duration of the count animation in milisecond eg. 5000', 'nayar-core' ),
			]
		);

		$this->add_control(
			'steps',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Counter Steps', 'nayar-core' ),
				'default' => 10,
				'description' => esc_html__( 'Counter steps eg. 10', 'nayar-core' ),
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label' => __('Icon Type', 'nayar-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'icon' => __('Icon', 'nayar-core'),
					'none' => __('None', 'nayar-core'),
				],
				'condition' => [
					'layout!' => ['layout-4'],
				],
			]
		);
		$this->add_control(
			'counter_icon',
			[
				'label'            => __( 'Choose Icon', 'nayar-core' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'icon-rt-paper-plane',
					'library' => 'solid',
				],
				'condition' => [
					'icon_type' => ['icon'],
					'layout!' => ['layout-4'],
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
					'{{WRAPPER}} .rt-counter-layout' => 'text-align: {{VALUE}};',
				],
			]
		);

		// scroll animation
		$this->add_control(
			'scroll_animation',
			[
				'label'        => __( 'Scroll Animation', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'nayar-core' ),
				'label_off'    => __( 'Hide', 'nayar-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'x_range',
			[
				'label'       => esc_html__( 'Animation Property', 'nayar-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'x' => __( 'x', 'nayar-core' ),
					'y' => __( 'y', 'nayar-core' ),
					'z' => __( 'z', 'nayar-core' ),
					'rotateX' => __( 'rotateX', 'nayar-core' ),
					'rotateY' => __( 'rotateY', 'nayar-core' ),
					'rotateZ' => __( 'rotateZ', 'nayar-core' ),
					'scaleX' => __( 'scaleX', 'nayar-core' ),
					'scaleY' => __( 'scaleY', 'nayar-core' ),
					'scaleZ' => __( 'scaleZ', 'nayar-core' ),
					'scale' => __( 'scale', 'nayar-core' ),
				],
				'label_block' => true,
				'default'     => 'y',
				'condition'   => [
					'scroll_animation' => ['yes'],
				],
			]
		);
		$this->add_control(
			'y_range',
			[
				'label'       => esc_html__( 'Animation Property', 'nayar-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'x' => __( 'x', 'nayar-core' ),
					'y' => __( 'y', 'nayar-core' ),
					'z' => __( 'z', 'nayar-core' ),
					'rotateX' => __( 'rotateX', 'nayar-core' ),
					'rotateY' => __( 'rotateY', 'nayar-core' ),
					'rotateZ' => __( 'rotateZ', 'nayar-core' ),
					'scaleX' => __( 'scaleX', 'nayar-core' ),
					'scaleY' => __( 'scaleY', 'nayar-core' ),
					'scaleZ' => __( 'scaleZ', 'nayar-core' ),
					'scale' => __( 'scale', 'nayar-core' ),
				],
				'label_block' => true,
				'default'     => 'x',
				'condition'   => [
					'scroll_animation' => ['yes'],
				],
			]
		);
		$this->add_control(
			'range_one',
			[
				'label'       => esc_html__( 'Range Value One', 'nayar-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 50,
				'condition'   => [
					'scroll_animation' => ['yes'],
				],
			]
		);
		$this->add_control(
			'range_two',
			[
				'label'       => esc_html__( 'Range Value Two', 'nayar-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 0,
				'condition'   => [
					'scroll_animation' => ['yes'],
				],
			]
		);

		$this->end_controls_section();

		// Title setting
		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title Style', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'label'    => esc_html__( 'Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .rt-counter-layout .rt-counter-box .counter-label',
			]
		);

		$this->add_control(
			'title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-counter-layout .rt-counter-box .counter-label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'title_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-counter-box .counter-label' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'              => __( 'Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ '%','px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-counter-box .counter-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'title_space',
			[
				'label'      => __( 'Space', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-counter-layout .rt-counter-box .counter-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'title_shape_display',
			[
				'label'        => __( 'Shape Display', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'nayar-core' ),
				'label_off'    => __( 'Hide', 'nayar-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'title_shape_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Shape Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .title_shape_yes .counter-label:before' => 'background: {{VALUE}}',
				],
				'condition'   => [
					'title_shape_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_shape_width',
			[
				'label'      => __( 'Shape Width', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .title_shape_yes .counter-label:before' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'title_shape_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_shape_height',
			[
				'label'      => __( 'Shape Height', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .title_shape_yes .counter-label:before' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'title_shape_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_shape_position',
			[
				'label'      => __( 'Shape Top/Bottom Position', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .title_shape_yes .counter-label:before' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'title_shape_display' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Image style
		$this->start_controls_section(
			'image_style',
			[
				'label'     => esc_html__( 'Image', 'nayar-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'layout-5',
				],
			]
		);

		$this->add_responsive_control(
			'image_max_width',
			[
				'label'      => __( 'Image Max Width', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-counter-layout .counter-image img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// Counter number setting
		$this->start_controls_section(
			'counter_style',
			[
				'label' => esc_html__( 'Counter Style', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_typo',
				'label'    => esc_html__( 'Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .rt-counter-layout .rt-counter-box .counter-number',
			]
		);

		$this->add_control(
			'counter_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-counter-layout .rt-counter-box .counter-number' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'counter_stroke_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Stroke Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-counter-layout .rt-counter-box .counter-number' => '-webkit-text-stroke: 2px {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'gradient_display',
			[
				'label'        => __( 'Gradient Counter', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'nayar-core' ),
				'label_off'    => __( 'Hide', 'nayar-core' ),
				'return_value' => 'counter-gradient',
				'default'      => 'no',
				'condition' => [
					'layout' => 'layout-2',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'counter_gradient',
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .rt-counter-layout-2 .rt-counter-box .counter-number',
				'return_value' => 'counter-gradient',
				'condition' => [
					'layout' => ['layout-2'], 'gradient_display' => ['counter-gradient'],
				],
			]
		);

		$this->add_control(
			'counter_space',
			[
				'label'      => __( 'Counter Space', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-counter-layout .rt-counter-box .counter-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'counter_unit_ty',
                'label'    => esc_html__( 'Counter Unit', 'nayar-core' ),
                'selector' => '{{WRAPPER}} .rt-counter-layout .rt-counter-box .counter-unit',
            ]
        );

		$this->end_controls_section();

		// Counter shape setting
		$this->start_controls_section(
			'counter_shape_style',
			[
				'label' => esc_html__( 'Shape Style', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'layout-1',
				],
			]
		);
		$this->add_control(
			'shape_display',
			[
				'label'        => __( 'Shape Display', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'nayar-core' ),
				'label_off'    => __( 'Hide', 'nayar-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'counter_shape',
			[
				'label'       => esc_html__( 'Counter Shape', 'nayar-core' ),
				'type'        => Controls_Manager::SELECT2,
				'default'     => 'shape-1',
				'options'   => [
					'shape-1' => __( 'Shape 01', 'nayar-core' ),
					'shape-2' => __( 'Shape 02', 'nayar-core' ),
					'shape-3' => __( 'Shape 03', 'nayar-core' ),
					'shape-4' => __( 'Shape 04', 'nayar-core' ),
				],
				'condition'   => [
					'shape_display' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		// Icon style
		$this->start_controls_section(
			'counter_icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => 'layout-4',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'icon_typo',
				'label'    => esc_html__( 'Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .rt-counter-layout .bg-shape',
			]
		);
		$this->add_control(
			'icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-counter-layout .bg-shape' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'icon_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-counter-layout .bg-shape' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_padding',
			[
				'label'              => __( 'Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-counter-layout .bg-shape' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_radius',
			[
				'label'              => __( 'Radius', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-counter-layout .bg-shape' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_space',
			[
				'label'      => __( 'Icon Space', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-counter-layout .bg-shape' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout!' => 'layout-3',
				],
			]
		);

		$this->add_control(
			'icon_space2',
			[
				'label'      => __( 'Icon Space', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-counter-layout-3 .rt-counter-box' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => 'layout-3',
				],
			]
		);

		$this->add_control(
			'icon_width',
			[
				'label'      => __( 'Icon Width', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-counter-layout .bg-shape' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'icon_height',
			[
				'label'      => __( 'Icon Height', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rt-counter-layout .bg-shape' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Box Style
		$this->start_controls_section(
			'box_style',
			[
				'label' => esc_html__( 'Box Style', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'box_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-counter-layout .rt-counter-box' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'exclude' => [ // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .rt-counter-layout .rt-counter-box',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'box_border',
				'label'    => __( 'Border', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .rt-counter-layout .rt-counter-box',
			]
		);
		$this->add_responsive_control(
			'box_padding',
			[
				'label'              => __( 'Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-counter-layout .rt-counter-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'box_radius',
			[
				'label'              => __( 'Radius', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-counter-layout .rt-counter-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
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
		$data  = $this->get_settings();
		$template = 'view-1';
		Fns::get_template( "elementor/counter/$template", $data );
	}

}