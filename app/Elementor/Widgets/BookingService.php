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
use Elementor\Group_Control_Typography;
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
		$this->register_nayar_filter_style_controls();
	}

	/**
	 * Add a control — patched for the inherited Radius Booking controls.
	 *
	 * The Radius Booking style controls (Card, Image, Title, Description, Price,
	 * Duration, Category Badge, Button, Category Filter) have no selectors: their
	 * values only reach the plugin React app. Selectors for the Nayar markup are
	 * merged in here, while the parent registers each control.
	 *
	 * This can't be done with update_control(): on the frontend Elementor's
	 * optimized control loading files a control without selectors as a content
	 * control, and an update that adds selectors leaves that stale copy in
	 * place — so the CSS file is generated without them (editor only works).
	 *
	 * @param string $id      Control ID.
	 * @param array  $args    Control arguments.
	 * @param array  $options Control options.
	 *
	 * @return bool
	 */
	public function add_control( $id, array $args, $options = [] ) {
		$overrides = $this->get_parent_control_overrides();

		if ( isset( $overrides[ $id ] ) ) {
			$override = $overrides[ $id ];

			// Blank defaults: nothing overrides the Nayar theme design until a value is set.
			if ( ! empty( $override['blank_default'] ) ) {
				$args['default'] = isset( $args['type'] ) && Controls_Manager::SLIDER === $args['type'] ? [ 'unit' => 'px', 'size' => '' ] : '';
			}

			unset( $override['blank_default'] );
			$args = array_merge( $args, $override );
		}

		return parent::add_control( $id, $args, $options );
	}

	/**
	 * Overrides for the inherited Radius Booking controls, keyed by control ID.
	 *
	 * @return array
	 */
	private function get_parent_control_overrides() {
		static $overrides = null;

		if ( null !== $overrides ) {
			return $overrides;
		}

		$w     = '{{WRAPPER}}';
		$item  = $w . ' .booking-service-item';
		$img   = $w . ' .booking-img';
		$title = $w . ' .booking-title';
		$desc  = $w . ' .booking-desc';
		$price = $w . ' .booking-price';
		$dur   = $w . ' .booking-duration';
		$badge = $w . ' .booking-category';
		$btn   = $w . ' .nayar-booking-service__btn';

		$bar    = $w . ' .nayar-booking-service__filter';
		$f_btn  = $w . ' .nayar-booking-service__filter-btn';
		$active = $f_btn . '.active';
		// Inactive/hover rules skip the active button so they never override it.
		$idle   = $f_btn . ':not(.active)';

		$card_selectors = [
			// Card.
			'primary_color'           => [ $w . ' .nayar-booking-service' => '--rt-primary-color: {{VALUE}};' ],
			'card_bg_color'           => [ $item => 'background-color: {{VALUE}};' ],
			'card_border_color'       => [ $item => 'border: 1px solid {{VALUE}};' ],
			'card_border_radius'      => [ $item => 'border-radius: {{SIZE}}{{UNIT}}; overflow: hidden;' ],
			'card_padding'            => [ $item => 'padding: {{SIZE}}{{UNIT}};' ],
			'card_gap'                => [ $w . ' .nayar-booking-service__inner' => 'gap: {{SIZE}}{{UNIT}};' ],
			// Image.
			'image_height'            => [ $img => 'height: {{SIZE}}{{UNIT}}; width: 100%; object-fit: cover;' ],
			'image_border_radius'     => [ $img . ', ' . $w . ' .booking-img-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};' ],
			// Title.
			'title_color'             => [ $title => 'color: {{VALUE}};' ],
			'title_font_size'         => [ $title => 'font-size: {{SIZE}}{{UNIT}};' ],
			'title_font_weight'       => [ $title => 'font-weight: {{VALUE}};' ],
			'title_margin_bottom'     => [ $title => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			// Description.
			'desc_color'              => [ $desc => 'color: {{VALUE}};' ],
			'desc_font_size'          => [ $desc => 'font-size: {{SIZE}}{{UNIT}};' ],
			'desc_line_height'        => [ $desc => 'line-height: {{SIZE}}{{UNIT}};' ],
			// Price.
			'price_color'             => [ $price => 'color: {{VALUE}};' ],
			'price_font_size'         => [ $price => 'font-size: {{SIZE}}{{UNIT}};' ],
			'price_font_weight'       => [ $price => 'font-weight: {{VALUE}};' ],
			// Duration.
			'duration_color'          => [ $dur => 'color: {{VALUE}};' ],
			'duration_font_size'      => [ $dur => 'font-size: {{SIZE}}{{UNIT}};' ],
			'duration_icon_size'      => [ $dur . ' svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			// Category Badge.
			'badge_bg_color'          => [ $badge => 'background-color: {{VALUE}};' ],
			'badge_text_color'        => [ $badge => 'color: {{VALUE}};' ],
			'badge_font_size'         => [ $badge => 'font-size: {{SIZE}}{{UNIT}};' ],
			'badge_border_radius'     => [ $badge => 'border-radius: {{SIZE}}{{UNIT}};' ],
			// Book Now Button.
			'button_bg_color'         => [ $btn => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
			'button_text_color'       => [ $btn => 'color: {{VALUE}};' ],
			'button_hover_bg_color'   => [ $btn . ':hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
			'button_hover_text_color' => [ $btn . ':hover' => 'color: {{VALUE}};' ],
			'button_font_size'        => [ $btn => 'font-size: {{SIZE}}{{UNIT}};' ],
			'button_border_radius'    => [ $btn => 'border-radius: {{SIZE}}{{UNIT}};' ],
			'button_padding_x'        => [ $btn => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};' ],
			'button_padding_y'        => [ $btn => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};' ],
		];

		$filter_selectors = [
			'filter_active_bg'       => [ $active => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ],
			'filter_active_text'     => [ $active => 'color: {{VALUE}};' ],
			'filter_inactive_bg'     => [ $idle => 'background-color: {{VALUE}};' ],
			'filter_inactive_text'   => [ $idle => 'color: {{VALUE}};' ],
			'filter_inactive_border' => [ $idle => 'border-color: {{VALUE}};' ],
			'filter_font_size'       => [ $f_btn => 'font-size: {{SIZE}}{{UNIT}};' ],
			'filter_border_radius'   => [ $f_btn => 'border-radius: {{SIZE}}{{UNIT}};' ],
			'filter_gap'             => [ $bar => 'gap: {{SIZE}}{{UNIT}};' ],
			'filter_margin_bottom'   => [ $bar => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		];

		$overrides = [];

		foreach ( $card_selectors as $control_id => $control_selectors ) {
			$overrides[ $control_id ] = [
				'selectors'     => $control_selectors,
				'blank_default' => true,
			];
		}

		foreach ( $filter_selectors as $control_id => $control_selectors ) {
			$overrides[ $control_id ] = [ 'selectors' => $control_selectors ];
		}

		// Original radius sliders stop at 30px; 100px allows a pill shape.
		foreach ( [ 'card_border_radius', 'image_border_radius', 'badge_border_radius', 'button_border_radius' ] as $control_id ) {
			$overrides[ $control_id ]['range'] = [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			];
		}

		// The original filter slider stops at 30px while defaulting to 9999px (pill).
		$overrides['filter_border_radius'] += [
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
				'%'  => [
					'min' => 0,
					'max' => 50,
				],
			],
			'default'    => [
				'unit' => 'px',
				'size' => 100,
			],
		];

		// 0px would collapse the image; leave the field empty to keep the theme height.
		$overrides['image_height']['range'] = [
			'px' => [
				'min' => 50,
				'max' => 600,
			],
		];

		// New card elements stay hidden until switched on, so existing designs don't change.
		$overrides['show_duration'] = [ 'default' => '' ];
		$overrides['show_category'] = [ 'default' => '' ];

		return $overrides;
	}

	/**
	 * Extra Category Filter style controls for the Nayar isotope filter bar:
	 * typography, padding, border, alignment and hover, injected into the
	 * inherited "Category Filter" section.
	 *
	 * @return void
	 */
	private function register_nayar_filter_style_controls() {
		$bar  = '{{WRAPPER}} .nayar-booking-service__filter';
		$btn  = '{{WRAPPER}} .nayar-booking-service__filter-btn';
		$idle = $btn . ':not(.active)';

		if ( ! $this->get_controls( 'filter_margin_bottom' ) ) {
			return;
		}

		$this->start_injection( [ 'of' => 'filter_margin_bottom' ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'nayar_filter_typography',
				'selector' => $btn,
			]
		);

		$this->add_responsive_control(
			'nayar_filter_padding',
			[
				'label'      => esc_html__( 'Padding', 'nayar-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					$btn => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nayar_filter_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'nayar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors'  => [
					$btn => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nayar_filter_align',
			[
				'label'     => esc_html__( 'Alignment', 'nayar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'nayar-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'nayar-core' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'nayar-core' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					$bar => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nayar_filter_heading_hover',
			[
				'label'     => esc_html__( 'Hover State', 'nayar-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'nayar_filter_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'nayar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					$idle . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nayar_filter_hover_text',
			[
				'label'     => esc_html__( 'Text Color', 'nayar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					$idle . ':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nayar_filter_hover_border',
			[
				'label'     => esc_html__( 'Border Color', 'nayar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					$idle . ':hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_injection();
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
            'layout_style',
            [
                'label'       => esc_html__( 'Layout', 'nayar-core' ),
                'type'        => Controls_Manager::SELECT2,
                'options'   => [
                    'layout-1' => __( 'Layout 01', 'nayar-core' ),
                    'layout-2' => __( 'Layout 02', 'nayar-core' ),
                    'layout-3' => __( 'Layout 03', 'nayar-core' ),
                ],
                'default'     => 'layout-1',
            ]
        );

		$this->add_control(
			'nayar_description_limit',
			[
				'label'       => esc_html__( 'Description Max Words', 'nayar-core' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'default'     => 20,
				'description' => esc_html__( '0 hides the description.', 'nayar-core' ),
				'condition'   => [
					'layout_style' => [ 'layout-2', 'layout-3' ],
				],
			]
		);

        $this->add_control(
            'nayar_button_text',
            [
                'label'       => esc_html__( 'Button Text', 'nayar-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Book Your Slot', 'nayar-core' ),
                'label_block' => true,
                'condition'   => [
                    'layout_style' => [ 'layout-2', 'layout-3' ],
                ],
            ]
        );

        $this->add_control(
            'nayar_category_isotope',
            [
                'label'        => esc_html__( 'Category Isotope', 'nayar-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'nayar-core' ),
                'label_off'    => esc_html__( 'Off', 'nayar-core' ),
                'return_value' => 'yes',
                'default'      => '',
                'description'  => esc_html__( 'Category filter tabs above the services. Works when "Filter by Category" is All Categories.', 'nayar-core' ),
            ]
        );

        $this->add_control(
            'nayar_filter_show_all',
            [
                'label'        => esc_html__( 'Show "All" Button', 'nayar-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'nayar-core' ),
                'label_off'    => esc_html__( 'Hide', 'nayar-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'description'  => esc_html__( 'When hidden, the first category is selected on load.', 'nayar-core' ),
                'condition'    => [
                    'nayar_category_isotope' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nayar_filter_all_text',
            [
                'label'       => esc_html__( 'Isotope "All" Text', 'nayar-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'All', 'nayar-core' ),
                'label_block' => true,
                'condition'   => [
                    'nayar_category_isotope' => 'yes',
                    'nayar_filter_show_all'  => 'yes',
                ],
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

		switch ( ! empty( $settings['layout_style'] ) ? $settings['layout_style'] : 'layout-1' ) {
			case 'layout-2':
				$template = 'view-2';
				break;
			case 'layout-3':
				$template = 'view-3';
				break;
			default:
				$template = 'view-1';
				break;
		}

		$template = apply_filters( 'nayar_booking_service_template', $template, $settings, $this );
		$template = sanitize_file_name( $template );

		if ( ! $template ) {
			$template = 'view-1';
		}

		Fns::get_template(
			"elementor/booking-service/{$template}",
			[
				'settings'       => $settings,
				'booking_markup' => $booking_markup,
				'category_names' => $this->get_category_names( $settings ),
				'wrapper_class'  => $this->get_wrapper_classes( $settings ),
			]
		);
	}

	/**
	 * Category names keyed by id, for the card Category Badge.
	 *
	 * @param array $settings Widget settings.
	 *
	 * @return array
	 */
	private function get_category_names( $settings ) {
		$names = [];

		if ( empty( $settings['show_category'] ) || 'yes' !== $settings['show_category'] || ! class_exists( '\RadiusTheme\RadiusBooking\Models\Category' ) ) {
			return $names;
		}

		foreach ( \RadiusTheme\RadiusBooking\Models\Category::query()->get() as $category ) {
			if ( ! empty( $category->id ) && ! empty( $category->name ) ) {
				$names[ (int) $category->id ] = $category->name;
			}
		}

		return $names;
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
		$style   = ! empty( $settings['layout_style'] ) ? $settings['layout_style'] : 'layout-1';

		$classes = [
			'nayar-booking-service',
			'nayar-booking-service--' . sanitize_html_class( $layout ),
			'nayar-booking-service--col-' . sanitize_html_class( $columns ),
			'nayar-booking-service--' . sanitize_html_class( $style ),
		];

		if ( ! empty( $settings['nayar_category_isotope'] ) && 'yes' === $settings['nayar_category_isotope'] ) {
			$classes[] = 'nayar-booking-service--isotope';
		}

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
