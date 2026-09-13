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

class AjaxSearch extends ElementorBase {

	public function __construct( $data = [], $args = null ) {
		$this->rt_name = esc_html__( 'RT Ajax Search', 'nayar-core' );
		$this->rt_base = 'rt-ajax-search';
		parent::__construct( $data, $args );
	}

	public function get_script_depends() {
		return [ 'rt-nice-select' ];
	}

	protected function register_controls() {

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'searches_word', array(
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Search Word', 'nayar-core' ),
				'default' => esc_html__( 'WordPress' , 'nayar-core' ),
				'label_block' => true,
			)
		);

		$this->start_controls_section(
			'sec_general',
			[
				'label' => esc_html__( 'General', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'placeholder',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Placeholder Text', 'nayar-core' ),
				'default'     => __( 'Type Your Keywords . . . ', 'nayar-core' ),
			]
		);

		$this->add_control(
			'category_display',
			[
				'label'        => __( 'Category Display', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'nayar-core' ),
				'label_off'    => __( 'Off', 'nayar-core' ),
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'btn_display',
			[
				'label'        => __( 'Button Text Display', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'nayar-core' ),
				'label_off'    => __( 'Off', 'nayar-core' ),
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'button_text',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Button Text', 'nayar-core' ),
				'default'     => __( 'Generate', 'nayar-core' ),
				'condition' => [
					'btn_display' => ['yes'],
				],
			]
		);

		$this->add_control(
			'popular_text',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Popular Search', 'nayar-core' ),
				'default'     => __( 'Popular Search:', 'nayar-core' ),
			]
		);

		$this->add_control(
			'repeat_display',
			[
				'label'        => __( 'Repeat Word Display', 'nayar-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'nayar-core' ),
				'label_off'    => __( 'Off', 'nayar-core' ),
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'word_repeat',
			[
				'label'   => esc_html__( 'Words Repeater', 'nayar-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ searches_word }}}',
				'default'     => [
					['searches_word' => 'Creative', ],
					['searches_word' => 'Business', ],
					['searches_word' => 'Agency', ],
					['searches_word' => 'Portfolio', ],
				],
				'condition' => [
					'repeat_display' => ['yes'],
				],
			]
		);

		$this->end_controls_section();

		// Input Settings
		$this->start_controls_section(
			'input_settings',
			[
				'label' => esc_html__( 'Input Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-search-box-form .search-box-input' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'input_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-search-box-form' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'input_height',
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
					'{{WRAPPER}} .rt-search-box-form .search-box-input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'              => __( 'Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-search-box-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'input_radius',
			[
				'label'              => __( 'Radius', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-search-box-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'input_border',
				'selector' => '{{WRAPPER}} .rt-search-box-form',
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
				'selector' => '{{WRAPPER}} .rt-search-box-form .rt-search-box-btn',
			]
		);

		$this->add_responsive_control(
			'button_radius',
			[
				'label'              => __( 'Radius', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-search-box-form .rt-search-box-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .rt-search-box-form .rt-search-box-btn' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .rt-search-box-form .rt-search-box-btn' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .rt-search-box-form .rt-search-box-btn' => 'color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}} .rt-search-box-form .rt-search-box-btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .rt-search-box-form .rt-search-box-btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'label' => __('Box Shadow', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-search-box-form .rt-search-box-btn',
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
					'{{WRAPPER}} .rt-search-box-form .rt-search-box-btn:hover' => 'color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}} .rt-search-box-form .rt-search-box-btn:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_hover_border',
				'selector' => '{{WRAPPER}} .rt-search-box-form .rt-search-box-btn:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_hover_box_shadow',
				'label' => __('Box Shadow', 'nayar-core'),
				'selector' => '{{WRAPPER}} .rt-search-box-form .rt-search-box-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Input Settings
		$this->start_controls_section(
			'other_settings',
			[
				'label' => esc_html__( 'Other Settings', 'nayar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cat_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Category Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-search-box-form .category-selector .nice-select span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'cat_list_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Category List Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-search-box-form .category-selector .nice-select .list li' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'cat_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Category Background Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-search-box-form .category-selector .nice-select .list' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'Popular_heading',
			[
				'label'     => __( 'Popular Search Item', 'nayar-core' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pop_label_typo',
				'label'    => esc_html__( 'Label Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .rt-search-text .popular-label',
			]
		);

		$this->add_control(
			'pop_search_label_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Popular Label Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-search-text .popular-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pop_item_typo',
				'label'    => esc_html__( 'Popular Item Typo', 'nayar-core' ),
				'selector' => '{{WRAPPER}} .rt-search-text .rt-search-key li a',
			]
		);

		$this->add_control(
			'pop_search_item_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Popular Search Item Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-search-text .rt-search-key li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pop_search_item_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Popular Search Item BG Color', 'nayar-core' ),
				'selectors' => [
					'{{WRAPPER}} .rt-search-text .rt-search-key li a' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'pop_search_item_padding',
			[
				'label'              => __( 'Padding', 'nayar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .rt-search-text .rt-search-key li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$data     = $this->get_settings();
		$template = 'view-1';
		Fns::get_template( "elementor/ajax-search/$template", $data );
	}

}