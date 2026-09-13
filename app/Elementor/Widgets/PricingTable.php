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
use RT\NayarCore\Helper\Fns;
use RT\NayarCore\Abstracts\ElementorBase;

if (!defined('ABSPATH')) {
	exit;
}

class PricingTable extends ElementorBase {

	public function __construct($data = [], $args = null) {
		$this->rt_name = esc_html__('RT Pricing Table', 'nayar-core');
		$this->rt_base = 'rt-pricing-table';
		parent::__construct($data, $args);
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rt_pricing_table',
			[
				'label' => esc_html__('Pricing Table Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Style', 'nayar-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'layout-1',
				'options' => [
					'layout-1' => __( 'Layout 1', 'nayar-core' ),
					'layout-2' => __( 'Layout 2', 'nayar-core' ),
					'layout-3' => __( 'Layout 3', 'nayar-core' ),
				],

			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'     => esc_html__( 'Alignment', 'nayar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'nayar-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'nayar-core' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'nayar-core' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__('Plan Name', 'nayar-core'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Standard',
				'label_block' => false,
			]
		);

		$this->add_control(
			'is_featured',
			[
				'label' => __('Is Featured ?', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'nayar-core'),
				'label_off' => __('No', 'nayar-core'),
				'return_value' => 'is-featured',
				'default' => false,
			]
		);

		$this->add_control(
			'featured_text',
			[
				'label' => esc_html__('Featured Text', 'nayar-core'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Featured',
				'label_block' => false,
				'condition' => [
					'is_featured' => 'is-featured',
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__('Subtitle', 'nayar-core'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => 'Manage and streamline operations acr osers multiple locations wenels',
				'rows' => 3,
			]
		);

		$this->add_control(
			'price',
			[
				'label' => esc_html__('Price', 'nayar-core'),
				'type' => Controls_Manager::TEXT,
				'default' => '$29.00',
				'label_block' => false,
			]
		);

		$this->add_control(
			'period',
			[
				'label' => esc_html__('Period', 'nayar-core'),
				'type' => Controls_Manager::TEXT,
				'default' => 'billed per month',
				'label_block' => false,
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__('Button Text', 'nayar-core'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Get Started',
				'label_block' => false,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __('Link', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'nayar-core'),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		// Features
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'faature_title', [
				'label' => __('Feature Title', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('List Title', 'nayar-core'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_icon',
			[
				'label' => __('Icon', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'icon-rt-correct',
					'library' => 'solid',
				],
			]
		);

		$repeater->add_control(
			'list_icon_color',
			[
				'label' => __('Icon Color', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .feature-lists {{CURRENT_ITEM}} i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-pricing-box-wrapper .feature-lists {{CURRENT_ITEM}} svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'list_title_color',
			[
				'label' => __('Title Color', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .feature-lists {{CURRENT_ITEM}} .list-item' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'list',
			[
				'label' => __('Feature List', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'faature_title' => __('Sync between pages', 'nayar-core'),
						'list_icon' => 'fas fa-check',
					],
					[
						'faature_title' => __('Powerful database store', 'nayar-core'),
						'list_icon' => 'fas fa-check',
					],
					[
						'faature_title' => __('Free / Pro Ads', 'nayar-core'),
						'list_icon' => 'fas fa-check',
					],
					[
						'faature_title' => __('Unlimited guests', 'nayar-core'),
						'list_icon' => 'fas fa-check',
					],
					[
						'faature_title' => __('Version history', 'nayar-core'),
						'list_icon' => 'fas fa-check',
					],
				],
				'title_field' => '{{{ faature_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'additional_settings',
			[
				'label' => esc_html__('Additional Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_CONTENT,
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
					'image' => __('Image', 'nayar-core'),
					'none' => __('None', 'nayar-core'),
				],
			]
		);

		$this->add_control(
			'bgicon',
			[
				'label' => __('Choose Icon', 'nayar-core'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-paper-plane',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => ['icon'],
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __('Choose Image', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_type' => ['image'],
				],
			]
		);

		$this->end_controls_section();

		// Title Settings
		//==============================================================
		$this->start_controls_section(
			'title_settings',
			[
				'label' => esc_html__('Title Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__('Typography', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper .plan-name',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Title Tag', 'nayar-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1' => esc_html__( 'H1', 'nayar-core' ),
					'h2' => esc_html__( 'H2', 'nayar-core' ),
					'h3' => esc_html__( 'H3', 'nayar-core' ),
					'h4' => esc_html__( 'H4', 'nayar-core' ),
					'h5' => esc_html__( 'H5', 'nayar-core' ),
					'h6' => esc_html__( 'H6', 'nayar-core' ),
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __('Title Spacing', 'nayar-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'allowed_dimensions' => 'vertical',
				'selectors' => [
					'{{WRAPPER}} .plan-name-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs(
			'title_style_tabs'
		);

		$this->start_controls_tab(
			'title_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .plan-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Hover Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .plan-name' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Price setting
		//==============================================================
		$this->start_controls_section(
			'price_settings',
			[
				'label' => esc_html__('Price Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pricing_heading',
			[
				'label' => __('Pricing Options', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				// 'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => esc_html__('Typography', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper .price-wrap .price',
			]
		);

		$this->start_controls_tabs(
			'price_style_tabs'
		);

		$this->start_controls_tab(
			'price_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_control(
			'price_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Price Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .price-wrap .price' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'price_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'price_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Price Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .price-wrap .price' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'period_heading',
			[
				'label' => __('Period Options', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'period_typography',
				'label' => esc_html__('Typography', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper .price-wrap .period',
			]
		);

		$this->start_controls_tabs(
			'period_style_tabs'
		);

		$this->start_controls_tab(
			'period_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_control(
			'period_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Period Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .price-wrap .period' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'period_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'period_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Period Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .price-wrap .period' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'pricing_separator',
			[
				'label' => __('Pricing Separator Options', 'nayar-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs(
			'separator_style_tabs'
		);

		$this->start_controls_tab(
			'separator_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_control(
			'separator_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Separator Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .price-wrap .seperator' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'separator_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'separator_color_hover',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Separator Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .price-wrap .seperator' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'separator_size',
			[
				'label' => __('Separator Size', 'nayar-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .price-wrap .seperator' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Sub Title
		//==============================================================
		$this->start_controls_section(
			'sub_title_settings',
			[
				'label' => esc_html__('Sub Title Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__('Typography', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper .subtitle',
			]
		);

		$this->add_responsive_control(
			'subtitle_list_spacing',
			[
				'label' => __('Spacing', 'nayar-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'allowed_dimensions' => 'vertical',
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs(
			'subtitle_style_tabs'
		);

		$this->start_controls_tab(
			'subtitle_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Sub Title Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .subtitle' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'subtitle_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'subtitle_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Sub Title Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .subtitle' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Is Featured Settings
		//==============================================================
		$this->start_controls_section(
			'is_featured_settings',
			[
				'label' => esc_html__('Feature Badge Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'is_featured' => 'is-featured',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'is_featured_typography',
				'label' => esc_html__('Typography', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper .is-featured',
			]
		);

		$this->start_controls_tabs(
			'is_featured_style_tabs'
		);

		$this->start_controls_tab(
			'is_featured_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_control(
			'is_featured_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .is-featured' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'is_featured_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Background Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .is-featured' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'is_featured_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'is_featured_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .is-featured' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'is_featured_bg_color_hover',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Background Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .is-featured' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Feature List Style
		//==============================================================
		$this->start_controls_section(
			'feature_list_settings',
			[
				'label' => esc_html__('Feature List Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'feature_list_typography',
				'label' => esc_html__('Typography', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper .feature-lists',
			]
		);

		$this->add_responsive_control(
			'feature_list_spacing',
			[
				'label' => __('Spacing', 'nayar-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'allowed_dimensions' => 'vertical',
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .feature-lists' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs(
			'feature_list_style_tabs'
		);

		$this->start_controls_tab(
			'feature_list_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_control(
			'feature_list_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .list-item' => 'color: {{VALUE}}',
				],
				'description' => esc_html__('This color will work if you don\'t set color from the list', 'nayar-core'),
			]
		);

		$this->add_control(
			'feature_icon_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('List Icon Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .feature-lists i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-pricing-box-wrapper .feature-lists svg path' => 'fill: {{VALUE}}',
				],
				'description' => esc_html__('This color will work if you don\'t set color from the list', 'nayar-core'),
			]
		);

		$this->add_control(
			'feature_icon_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('List Icon BG Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .feature-lists i' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'feature_list_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'feature_list_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .feature-lists li .list-item' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'feature_icon_color_hover',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('List Icon Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .feature-lists i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .feature-lists svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Icon / Image Settings
		//==============================================================
		$this->start_controls_section(
			'image_icon_settings',
			[
				'label' => esc_html__('Image / Icon Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image/Icon Size', 'nayar-core'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 400,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .icon-holder i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rt-pricing-box-wrapper .icon-holder img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],

			]
		);

		$this->add_responsive_control(
			'icon_x_position',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('X Position', 'nayar-core'),
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .icon-holder' => 'left: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'icon_y_position',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Y Position', 'nayar-core'),
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 700,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .icon-holder' => 'top: {{SIZE}}{{UNIT}};',
				],

			]
		);

		//Start Icon Style Tab
		$this->start_controls_tabs(
			'icon_style_tabs'
		);

		//Normal Style
		$this->start_controls_tab(
			'icon_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);
		$this->add_control(
			'icon_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .icon-holder i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'icon_type' => ['icon'],
				],
			]
		);

		$this->add_responsive_control(
			'icon_opacity',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image/Icon Opacity', 'nayar-core'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper .icon-holder' => 'Opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		//Hover Style
		$this->start_controls_tab(
			'icon_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .icon-holder i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'icon_type' => ['icon'],
				],
			]
		);

		$this->add_responsive_control(
			'icon_opacity_hover',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image/Icon Opacity Hover', 'nayar-core'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover .icon-holder' => 'Opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		//End Icon Style Tab

		$this->end_controls_section();

		// Button More Settings
		//==============================================================
		$this->start_controls_section(
			'button_settings',
			[
				'label' => esc_html__('Button Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'            => __( 'Choose Icon', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'icon-rt-right-arrow',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Radius', 'nayar-core'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => esc_html__('Button Typography', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-button .rt-primary-btn',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __('Button Padding', 'nayar-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
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
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		//Start button Style Tab
		$this->start_controls_tabs(
			'button_style_tabs'
		);

		//Normal Style
		$this->start_controls_tab(
			'button_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_control(
			'button_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-button .rt-primary-btn' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-button .icon-area i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-button .icon-area path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_bg',
				'label' => __('Background', 'nayar-core'),
				'types' => ['classic', 'gradient'],
				'fields_options'  => [
					'background' => [
						'label' => esc_html__( 'Background', 'nayar-core' ),
					],
				],
				'selector' => '{{WRAPPER}} .rt-button .rt-primary-btn, {{WRAPPER}} .rt-button .icon-area',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'label' => __('Border', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-button .rt-primary-btn, {{WRAPPER}} .rt-button .icon-area',
			]
		);

		$this->end_controls_tab();

		//Hover Style
		$this->start_controls_tab(
			'button_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color Hover', 'nayar-core'),
				'selectors' => [
					'{{WRAPPER}} .rt-button:hover .rt-primary-btn' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-button:hover .icon-area i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rt-button:hover .icon-area path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_bg_hover',
				'label' => __('Background', 'nayar-core'),
				'types' => ['classic', 'gradient'],
				'fields_options'  => [
					'background' => [
						'label' => esc_html__( 'Background', 'nayar-core' ),
					],
				],
				'selector' => '{{WRAPPER}} .rt-button:hover .rt-primary-btn, {{WRAPPER}} .rt-button:hover .icon-area',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border_hover',
				'label' => __('Border', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-button:hover .rt-primary-btn',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Box Settings
		//==============================================================
		$this->start_controls_section(
			'box_settings',
			[
				'label' => esc_html__('Box Settings', 'nayar-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'box_min_height',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Box Min Height', 'nayar-core'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_radius',
			[
				'label' => __('Border Radius', 'nayar-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => __('Box Padding', 'nayar-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'box_margin',
			[
				'label' => __('Box Margin', 'nayar-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs(
			'box_style_tabs'
		);

		$this->start_controls_tab(
			'box_style_normal_tab',
			[
				'label' => __('Normal', 'nayar-core'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __('Box Shadow', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_bg',
				'label' => __('Background', 'nayar-core'),
				'types' => ['classic', 'gradient'],
				'fields_options'  => [
					'background' => [
						'label' => esc_html__( 'Background', 'nayar-core' ),
					],
				],
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper::before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'label' => __('Border', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper',
			]
		);

		$this->add_control(
			'box_up',
			[
				'label' => __('Translate Y', 'nayar-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -50,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper' => 'transform: translateY( {{SIZE}}{{UNIT}} );',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_style_hover_tab',
			[
				'label' => __('Hover', 'nayar-core'),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'label' => __('Box Shadow Hover', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_bg_hover',
				'label' => __('Background Hover', 'nayar-core'),
				'types' => ['classic', 'gradient'],
				'fields_options'  => [
					'background' => [
						'label' => esc_html__( 'Background - Hover', 'nayar-core' ),
					],
				],
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper::after',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'box_border_hover',
				'label' => __('Border Hover', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-pricing-box-wrapper:hover',
			]
		);

		$this->add_control(
			'box_up_hover',
			[
				'label' => __('Translate Y on Hover', 'nayar-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -50,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-box-wrapper:hover' => 'transform: translateY( {{SIZE}}{{UNIT}} );',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
		$data = $this->get_settings();

		switch ( $data['layout'] ) {
			case 'layout-3':
				$template = 'view-3';
				break;
			case 'layout-2':
				$template = 'view-2';
				break;
			default:
				$template = 'view-1';
				break;
		}

		Fns::get_template( "elementor/pricing-table/$template", $data );
	}
}