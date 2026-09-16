<?php
//phpcs:disable
/**
 * Radius Booking Elementor integration.
 *
 * Replaces the Radius Booking "Service List" Elementor widget with the
 * Nayar Core "Booking Service" widget, without touching the Radius Booking
 * plugin source.
 *
 * Radius Booking and Elementor are optional third party dependencies: every
 * class, function and constant coming from them is verified before it is used,
 * so Nayar Core stays fatal free when either plugin (or both) is deactivated.
 *
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\NayarCore\Elementor\Integrations;

use RT\NayarCore\Traits\SingletonTraits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RadiusBooking {

	use SingletonTraits;

	/**
	 * Elementor widget name used by Radius Booking's Service List widget.
	 *
	 * Reused on purpose: Radius Booking detects this widget type inside the
	 * Elementor document to enqueue the service list app, and every page that
	 * already uses the original widget keeps rendering after the override.
	 */
	const WIDGET_NAME = 'rtrb_service_list';

	/**
	 * Original Radius Booking widget class, extended by the Nayar widget.
	 */
	const SOURCE_WIDGET_CLASS = '\RadiusTheme\RadiusBooking\Elementor\Widgets\ServiceListWidget';

	/**
	 * Nayar Core widget class. Referenced as a string so that it is never
	 * autoloaded (and never extends a missing class) while Radius Booking is
	 * unavailable.
	 */
	const WIDGET_CLASS = '\RT\NayarCore\Elementor\Widgets\BookingService';

	/**
	 * Radius Booking classes the widget relies on.
	 *
	 * @var string[]
	 */
	const REQUIRED_CLASSES = [
		'\RadiusTheme\RadiusBooking\Controllers\ServiceController',
	];

	/**
	 * Radius Booking helper functions the widget relies on.
	 *
	 * @var string[]
	 */
	const REQUIRED_FUNCTIONS = [
		'rtrb_pro_active',
		'get_rtrb_currency',
		'get_rtrb_currency_symbol',
	];

	/**
	 * Class constructor.
	 */
	public function __construct() {
		// Nothing Elementor related is hooked unless Elementor is actually loaded.
		// Only `elementor/loaded` is checked here: the Elementor class stack is
		// verified later, when the widgets are registered.
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// Priority 20: Radius Booking registers its widgets on the default priority (10).
		add_action( 'elementor/widgets/register', [ $this, 'register_widget' ], 20 );

		// The Nayar markup uses the Radius Booking booking form modal, which
		// lives in the plugin "site" bundle. Radius Booking only loads that
		// bundle for its appointment form widget, so it is requested here for
		// every page holding the Booking Service widget.
		add_filter( 'rtrb_should_load_frontend_assets', [ $this, 'maybe_load_booking_assets' ] );
	}

	/**
	 * Tell Radius Booking to enqueue the booking form bundle when the current
	 * page renders the Booking Service widget.
	 *
	 * @param bool $should_load Radius Booking decision.
	 *
	 * @return bool
	 */
	public function maybe_load_booking_assets( $should_load ) {
		if ( $should_load || is_admin() || ! self::is_elementor_active() ) {
			return $should_load;
		}

		$post_id = get_queried_object_id();

		if ( ! $post_id ) {
			return $should_load;
		}

		$elementor = \Elementor\Plugin::$instance;

		if ( ! isset( $elementor->db, $elementor->documents ) || ! $elementor->db->is_built_with_elementor( $post_id ) ) {
			return $should_load;
		}

		$document = $elementor->documents->get( $post_id );

		if ( ! $document ) {
			return $should_load;
		}

		return $this->elements_have_widget( $document->get_elements_data(), self::WIDGET_NAME );
	}

	/**
	 * Recursively look for a widget type inside Elementor element data.
	 *
	 * @param array  $elements    Elementor elements data.
	 * @param string $widget_name Widget type to find.
	 *
	 * @return bool
	 */
	private function elements_have_widget( $elements, $widget_name ) {
		if ( ! is_array( $elements ) ) {
			return false;
		}

		foreach ( $elements as $element ) {
			if ( isset( $element['widgetType'] ) && $widget_name === $element['widgetType'] ) {
				return true;
			}

			if ( ! empty( $element['elements'] ) && $this->elements_have_widget( $element['elements'], $widget_name ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Swap the Radius Booking Service List widget for the Nayar Booking Service widget.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 *
	 * @return void
	 */
	public function register_widget( $widgets_manager ) {
		if ( ! $this->is_supported( $widgets_manager ) ) {
			return;
		}

		// Elementor >= 3.5. Keeps the panel free of a duplicate entry.
		if ( method_exists( $widgets_manager, 'unregister' ) ) {
			$widgets_manager->unregister( self::WIDGET_NAME );
		}

		$widget_class = self::WIDGET_CLASS;

		// Loads (and therefore extends) the Radius Booking widget only now,
		// after every dependency has been verified.
		if ( ! class_exists( $widget_class ) ) {
			return;
		}

		$widgets_manager->register( new $widget_class() );
	}

	/**
	 * Is Elementor available?
	 *
	 * @return bool
	 */
	public static function is_elementor_active() {
		return did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) && class_exists( '\Elementor\Widget_Base' );
	}

	/**
	 * Is Radius Booking available with everything this widget needs?
	 *
	 * @return bool
	 */
	public static function is_radius_booking_active() {
		if ( ! defined( 'RADIUS_BOOKING_VERSION' ) ) {
			return false;
		}

		foreach ( self::REQUIRED_CLASSES as $class_name ) {
			if ( ! class_exists( $class_name ) ) {
				return false;
			}
		}

		foreach ( self::REQUIRED_FUNCTIONS as $function_name ) {
			if ( ! function_exists( $function_name ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Every dependency required to register the widget.
	 *
	 * @param mixed $widgets_manager Elementor widgets manager.
	 *
	 * @return bool
	 */
	private function is_supported( $widgets_manager ) {
		if ( ! self::is_elementor_active() ) {
			return false;
		}

		if ( ! is_object( $widgets_manager ) || ! method_exists( $widgets_manager, 'register' ) ) {
			return false;
		}

		if ( ! self::is_radius_booking_active() ) {
			// Radius Booking inactive -> leave Elementor exactly as it is.
			return false;
		}

		// Checked last on purpose: the Radius Booking widget class extends
		// Elementor\Widget_Base, so it must never be autoloaded before Elementor
		// is confirmed above.
		if ( ! class_exists( self::SOURCE_WIDGET_CLASS ) ) {
			return false;
		}

		/**
		 * Allows disabling the Service List override from the theme.
		 *
		 * @param bool $enabled Whether the override should run.
		 */
		return (bool) apply_filters( 'nayar_booking_service_override_enabled', true );
	}
}
