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
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use RT\NayarCore\Abstracts\ElementorBase;
use RT\NayarCore\Helper\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Title extends ElementorBase {

	public function __construct( $data = [], $args = null ) {
		$this->rt_name = esc_html__( 'RT Section Title', 'nayar-core' );
		$this->rt_base = 'rt-title';
		parent::__construct( $data, $args );
	}

	public function get_script_depends() {
		return [ 'rt-animated-headline' ];
	}
	public function get_style_depends() {
		return [ 'rt-animated-headline' ];
	}

	protected function register_controls() {
		/* General Options */

		$this->start_controls_section(
			'sec_general',
			[
				'label' => esc_html__( 'General', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_layout',
			[
				'label'       => esc_html__( 'Title Layout', 'nayar-core' ),
				'type'        => Controls_Manager::SELECT2,
				'options'   => [
					'layout-1' => __( 'Layout 01', 'nayar-core' ),
					'layout-2' => __( 'Layout 02', 'nayar-core' ),
				],
				'default'     => 'layout-1',
			]
		);

		$this->add_control(
			'top_sub_title',
			[
				'label'       => esc_html__( 'Top Sub Title', 'nayar-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Why Choose Our About', 'nayar-core' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Main Title', 'nayar-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => __( 'Welcome To Our Nayar', 'nayar-core' ),
				'description' => esc_html__( "If you would like to use different color then separate word by <span>.", 'nayar-core' ),
			]
		);

		$this->add_control(
			'shadow_title_display',
			[
				'label'        => __( 'Shadow Title Display', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'nayar-core' ),
				'label_off'    => __( 'Off', 'nayar-core' ),
				'default'       => 'no',
				'condition'  => [
					'title_layout' => 'layout-1',
				],
			]
		);

		$this->add_control(
			'shadow_title',
			[
				'label'       => esc_html__( 'Shadow Title', 'nayar-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => __('About', 'nayar-core' ),
				'description' => esc_html__( 'Only use layout 1', 'nayar-core' ),
				'condition'  => [
					'shadow_title_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'animation_headline_display',
			[
				'label'        => __( 'Animation Headline Display', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'nayar-core' ),
				'label_off'    => __( 'Off', 'nayar-core' ),
				'default'       => 'no',
			]
		);

		$this->add_control(
			'headline_title',
			[
				'label'       => esc_html__( 'Headline Title', 'nayar-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'rows'        => 3,
				'default'     => __('About', 'nayar-core' ),
				'condition'  => [
					'animation_headline_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'nayar-core' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default'     => __('Manage and streamline operations across multiple locations, sales channels, and employees to improve efficiency and your bottom line.', 'nayar-core' ),
				'condition'  => [
					'title_layout' => 'layout-1',
				],
			]
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'list_text',
			[
				'label'       => __( 'List Text', 'nayar-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Powerful database store', 'nayar-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_icon_type',
			[
				'label'   => __( 'Icon Type', 'nayar-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'  => __( 'Icon', 'nayar-core' ),
					'image' => __( 'Image', 'nayar-core' ),
				],
			]
		);
		$repeater->add_control(
			'list_icon',
			[
				'label'            => __( 'Choose Icon', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'icon-rt-correct',
					'library' => 'solid',
				],
				'condition'        => [
					'list_icon_type' => 'icon',
				],
			]
		);
		$repeater->add_control(
			'list_image',
			[
				'label'     => __( 'Choose Image', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'list_icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'show_feature_list',
			[
				'label'        => __( 'Feature List', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'nayar-core' ),
				'label_off'    => __( 'Off', 'nayar-core' ),
				'return_value' => 'is-feature',
				'condition'  => [
					'title_layout' => 'layout-1',
				],
			]
		);

		$this->add_control(
			'feature_lists',
			[
				'label'       => __( 'Feature List', 'nayar-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'list_text'        => __( 'Powerful database store', 'nayar-core' ),
					],
					[
						'list_text'        => __( 'Easy to access all projects', 'nayar-core' ),
					],
					[
						'list_text'        => __( 'Effortless courier allocation', 'nayar-core' ),
					],
					[
						'list_text'        => __( 'Widest coverage network', 'nayar-core' ),
					],

				],
				'title_field' => '{{{ name }}}',
				'condition'   => [
					'show_feature_list' => [ 'is-feature' ],
					'title_layout' => ['layout-1'],
				],
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'     => __( 'Alignment', 'nayar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'       => '',
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
					'{{WRAPPER}} .section-title-wrapper' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Main Title Settings
		$this->start_controls_section(
			'title_settings',
			[
				'label' => esc_html__( 'Title Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .main-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_color_two',
			[
				'type'        => Controls_Manager::COLOR,
				'label'       => esc_html__( 'Color 2', 'nayar-core' ),
				'description' => esc_html__( "If you would like to use different color then separate word by <span> from main title.", 'nayar-core' ),
				'selectors'   => [
					'{{WRAPPER}} .section-title-wrapper .main-title span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_gradient_change_display',
			[
				'label'        => __( 'Gradient Title', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'nayar-core' ),
				'label_off'    => __( 'Hide', 'nayar-core' ),
				'return_value' => 'title-gradient',
				'default'      => 'no',
				'condition' => [
					'title_layout' => 'layout-1',
				],
			]
		);

		$this->add_control(
			'title_gradient_animation',
			[
				'label'       => esc_html__( 'Title Animation', 'nayar-core' ),
				'type'        => Controls_Manager::SELECT2,
				'options'   => [
					'default-animation' => __( 'Default', 'nayar-core' ),
					'title-gradient-animation' => __( 'Animation', 'nayar-core' ),
				],
				'default'     => 'title-gradient-animation',
				'condition' => [
					'title_layout' => ['layout-1'], 'title_gradient_change_display' => ['title-gradient'],
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'title_gradient_color',
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .section-title-wrapper .title-gradient',
				'return_value' => 'title-gradient',
				'condition' => [
					'title_layout' => ['layout-1'], 'title_gradient_change_display' => ['title-gradient'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typo',
				'label'    => esc_html__( 'Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .section-title-wrapper .main-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_span_typo',
				'label'    => esc_html__( 'Typo 2', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .section-title-wrapper .main-title span',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'text_stroke',
				'selector' => '{{WRAPPER}} .section-title-wrapper .main-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .section-title-wrapper .main-title',
			]
		);

		$this->add_responsive_control(
			'heading_margin',
			[
				'label'              => __( 'Margin', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .main-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'title_image_aline',
			[
				'label'       => esc_html__( 'Title Inline Image Align', 'nayar-core' ),
				'type'        => Controls_Manager::SELECT2,
				'options'   => [
					'baseline' => __( 'Baseline', 'nayar-core' ),
					'middle' => __( 'Middle', 'nayar-core' ),
					'bottom' => __( 'Bottom', 'nayar-core' ),
				],
				'default'     => 'middle',
			]
		);

		$this->add_control(
			'main_title_tag',
			[
				'label'   => esc_html__( 'Main Title Tag', 'nayar-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1' => esc_html__( 'H1', 'nayar-core' ),
					'h2' => esc_html__( 'H2', 'nayar-core' ),
					'h3' => esc_html__( 'H3', 'nayar-core' ),
					'h4' => esc_html__( 'H4', 'nayar-core' ),
					'h5' => esc_html__( 'H5', 'nayar-core' ),
					'h6' => esc_html__( 'H6', 'nayar-core' ),
					'span' => esc_html__( 'Span', 'nayar-core' ),
					'div' => esc_html__( 'Div', 'nayar-core' ),
				],
			]
		);

		$this->end_controls_section();

		// Top Sub Title
		$this->start_controls_section(
			'top_title_settings',
			[
				'label' => esc_html__( 'Sub Title Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sub_title_style',
			[
				'label'     => __( 'Sub Title Style', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => [
					'default'  => __( 'Default', 'nayar-core' ),
					'left-right-shape'  => __( 'Sub Title Shape', 'nayar-core' ),
				],
			]
		);

		$this->add_control(
			'top_title_icon_type',
			[
				'label'   => __( 'Icon Type', 'nayar-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'  => __( 'Icon', 'nayar-core' ),
					'image' => __( 'Image', 'nayar-core' ),
				],
			]
		);

		$this->add_control(
			'top_title_icon',
			[
				'label'   => __( 'Choose Icons', 'nayar-core' ),
				'type'    => \Elementor\Controls_Manager::ICON,
				'include' => [
					'icon-rt-arrow-right-1',
					'icon-rt-correct',
					'icon-rt-arrow-vector',
					'icon-rt-chevron-right',
				],
				'default' => '',
				'condition' => [
					'top_title_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'top_title_image',
			[
				'label'     => __( 'Choose Image', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'top_title_icon_type' => 'image',
				],
			]
		);


		$this->add_control(
			'icon_position',
			[
				'label'     => __( 'Icon Position', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'left'  => __( 'Left', 'nayar-core' ),
					'right' => __( 'Right', 'nayar-core' ),
					'both'  => __( 'Both', 'nayar-core' ),
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'top_title_icon_type',
							'operator' => '==',
							'value'    => 'image',
						],
						[
							'name'     => 'top_title_icon',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'top_title_right_icon_type',
			[
				'label'     => __( 'Right Icon Type', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'icon',
				'options'   => [
					'icon'  => __( 'Icon', 'nayar-core' ),
					'image' => __( 'Image', 'nayar-core' ),
				],
				'separator' => 'before',
				'condition' => [
					'icon_position' => [ 'right', 'both' ],
				],
			]
		);

		$this->add_control(
			'top_title_right_icon',
			[
				'label'       => __( 'Right Icon', 'nayar-core' ),
				'type'        => \Elementor\Controls_Manager::ICON,
				'include'     => [
					'icon-rt-arrow-right-1',
					'icon-rt-correct',
					'icon-rt-arrow-vector',
					'icon-rt-chevron-right',
				],
				'default'     => '',
				'description' => __( 'Leave empty to use the left icon.', 'nayar-core' ),
				'condition'   => [
					'icon_position'             => [ 'right', 'both' ],
					'top_title_right_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'top_title_right_image',
			[
				'label'     => __( 'Right Image', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_position'             => [ 'right', 'both' ],
					'top_title_right_icon_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'top_title_right_image_width',
			[
				'label'      => __( 'Right Image Width', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 200,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .section-title-wrapper .top-sub-title .sub-title-image-right' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
				'condition'  => [
					'icon_position'             => [ 'right', 'both' ],
					'top_title_right_icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'top_title_icon_size',
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
				'selectors'  => [
					'{{WRAPPER}} .section-title-wrapper .top-sub-title i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'top_title_icon_type' => 'icon',
					'top_title_icon!'     => '',
				],
			]
		);

		$this->add_responsive_control(
			'top_title_image_width',
			[
				'label'      => __( 'Image Width', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 200,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .section-title-wrapper .top-sub-title .sub-title-image' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
				'condition'  => [
					'top_title_icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'top_title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .top-sub-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'top_title_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .top-sub-title i'        => 'color: {{VALUE}}',
					'{{WRAPPER}} .section-title-wrapper .top-sub-title svg path' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'top_title_icon_type' => 'icon',
					'top_title_icon!'     => '',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'top_title_bg_color',
				'label' => __('Background', 'nayar-core'),
				'types' => ['classic', 'gradient'],
				'fields_options'  => [
					'background' => [
						'label' => esc_html__( 'Background', 'nayar-core' ),
					],
				],
				'selector' => '{{WRAPPER}} .section-title-wrapper .top-sub-title',
				'condition' => [
					'sub_title_style!' => 'default',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'top_title_typo',
				'label'    => esc_html__( 'Typography', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .section-title-wrapper .top-sub-title',
			]
		);

		$this->add_responsive_control(
			'top_title_padding',
			[
				'label'              => __( 'Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%'],
				'selectors'          => [
					'{{WRAPPER}} .top-sub-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => [
					'sub_title_style!' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'top_title_margin',
			[
				'label'              => __( 'Margin', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%'],
				'selectors'          => [
					'{{WRAPPER}} .top-sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		// Line Shape Settings
		$this->start_controls_section(
			'line_shape_settings',
			[
				'label' => esc_html__( 'Line Shape Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'description' => esc_html__( 'Only use layout 1', 'nayar-core' ),
				'condition'  => [
					'title_layout' => 'layout-1',
				],
			]
		);

		$this->add_control(
			'title_line_shape',
			[
				'label'        => __( 'Title Line Shape', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'nayar-core' ),
				'label_off'    => __( 'Off', 'nayar-core' ),
				'default'       => 'no',
				'return_value' => 'line-shape has-animation',
			]
		);

		$this->add_control(
			'line_shape_color',
			[
				'type'        => Controls_Manager::COLOR,
				'label'       => esc_html__( 'Shape Color', 'nayar-core' ),
				'selectors'   => [
					'{{WRAPPER}} .section-title-wrapper .line-shape:after' => 'background-color: {{VALUE}}',
				],
				'condition'  => [
					'title_line_shape' => 'line-shape has-animation',
				],
			]
		);

		$this->add_responsive_control(
			'line_shape_width',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Shape Width', 'nayar-core' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .line-shape.active-animation:after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'title_line_shape' => 'line-shape has-animation',
				],
			]
		);

		$this->add_responsive_control(
			'line_shape_height',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Shape Height', 'nayar-core' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .line-shape:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'title_line_shape' => 'line-shape has-animation',
				],
			]
		);

		$this->add_responsive_control(
			'line_shape_horizontal',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Shape Horizontal', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .line-shape:after' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'title_line_shape' => 'line-shape has-animation',
				],
			]
		);
		$this->add_responsive_control(
			'line_shape_vertical',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Shape Vertical', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .line-shape:after' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'title_line_shape' => 'line-shape has-animation',
				],
			]
		);

		$this->add_responsive_control(
			'line_shape_radius',
			[
				'label'              => __( 'Shape Radius', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .section-title-wrapper .line-shape:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition'  => [
					'title_line_shape' => 'line-shape has-animation',
				],
			]
		);

		$this->end_controls_section();

		// Title Shadow Settings
		$this->start_controls_section(
			'title_shadow_settings',
			[
				'label' => esc_html__( 'Shadow Title Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'description' => esc_html__( 'Only use layout 1', 'nayar-core' ),
				'condition'  => [
					'shadow_title_display' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_shadow_typo',
				'label'    => esc_html__( 'Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .section-title-wrapper .shadow-title-wrap .shadow-title',
			]
		);

		$this->add_control(
			'title_shadow_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Title Stroke Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .shadow-title-wrap .shadow-title' => '-webkit-text-stroke-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'shadow_title_horizontal',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Position Horizontal', 'nayar-core' ),
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .shadow-title-wrap' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_stroke_width',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Stroke Width', 'nayar-core' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .shadow-title-wrap .shadow-title' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Animation Headline Settings
		$this->start_controls_section(
			'animation_headline_settings',
			[
				'label' => esc_html__( 'Animation Headline Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'  => [
					'animation_headline_display' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_title_typo',
				'label'    => esc_html__( 'Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .rt-animated-headline .ah-words-wrapper p',
			]
		);

		$this->add_control(
			'headline_title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Headline Title Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-animated-headline .ah-words-wrapper p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'headline_settings',
			[
				'label'     => __( 'Headline Border Style', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'headline_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Title Border Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-animated-headline .ah-headline.clip .ah-words-wrapper:after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'headline_border_width',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Border Width', 'nayar-core' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-animated-headline .ah-headline.clip .ah-words-wrapper:after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'headline_border_height',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Border Height', 'nayar-core' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-animated-headline .ah-headline.clip .ah-words-wrapper:after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'headline_border_bottom',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Border Bottom', 'nayar-core' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-animated-headline .ah-headline.clip .ah-words-wrapper:after' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'headline_border_right',
			[
				'type'    => Controls_Manager::SLIDER,
				'label'   => esc_html__( 'Border Right', 'nayar-core' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-animated-headline .ah-headline.clip .ah-words-wrapper:after' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Description Settings
		$this->start_controls_section(
			'description_settings',
			[
				'label' => esc_html__( 'Description & List Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'  => [
					'title_layout' => 'layout-1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typo',
				'label'    => esc_html__( 'Typography', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .section-title-wrapper .description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'              => __( 'Margin', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ '%','px' ],
				'selectors'          => [
					'{{WRAPPER}} .section-title-wrapper .description p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'list_settings',
			[
				'label'     => __( 'List Settings (if you use list item in description)', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_typo',
				'label'    => esc_html__( 'List Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .section-title-wrapper ul.feature-list li',
			]
		);

		$this->add_control(
			'list_column',
			[
				'label'     => __( 'List Column', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => [
					'default'  => __( 'One Column', 'nayar-core' ),
					'two-column' => __( 'Two Column', 'nayar-core' ),
				],
			]
		);

		$this->add_control(
			'list_layout',
			[
				'label'     => __( 'List Layout', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'list-layout-1',
				'options'   => [
					'list-layout-1' => __( 'Layout 1', 'nayar-core' ),
					'list-layout-2' => __( 'layout 2', 'nayar-core' ),
				],
			]
		);

		$this->add_control(
			'list_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'List Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .feature-list li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'list_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'List Icon Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .feature-list li span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'list_icon_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'List Icon BG Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .section-title-wrapper .feature-list li span' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'list_icon_bg_size',
			[
				'label'      => __( 'Icon BG Size', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 10,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .section-title-wrapper .list-layout-2 li .icon' => 'width:{{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'list_layout' => 'list-layout-2',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'list_icon_border',
				'label'    => __( 'Border', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .section-title-wrapper .feature-list li span',
			]
		);
		$this->add_responsive_control(
			'list_icon_radius',
			[
				'label'              => __( 'Radius', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .section-title-wrapper .feature-list li span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'list_image_width',
			[
				'label'      => __( 'List Image Width', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .section-title-wrapper .feature-list li .icon img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'list_padding',
			[
				'label'              => __( 'List Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ '%','px' ],
				'selectors'          => [
					'{{WRAPPER}} .section-title-wrapper ul.feature-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'dsc_padding',
			[
				'label'              => __( 'Description Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ '%','px' ],
				'selectors'          => [
					'{{WRAPPER}} .section-title-wrapper .description p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		// Background Title Settings
		//==============================================================
		$this->start_controls_section(
			'Common Settings',
			[
				'label' => esc_html__( 'Common Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_title_wrap_margin',
			[
				'label'              => __( 'Wrapper Margin', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'allowed_dimensions' => 'vertical',
				'selectors'          => [
					'{{WRAPPER}} .section-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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

		switch ( $data['title_layout'] ) {
			case 'layout-2':
				$template = 'view-2';
				break;
			default:
				$template = 'view-1';
				break;
		}
		Fns::get_template( "elementor/title/$template", $data );
	}

}