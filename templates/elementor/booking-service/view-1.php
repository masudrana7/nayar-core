<?php
//phpcs:disable
/**
 * Booking Service widget markup.
 *
 * Override from the theme: nayar-core/elementor/booking-service/view-1.php
 *
 * Nayar renders its own server side markup — image, price, title and the book
 * button — from the Radius Booking services table instead of mounting the
 * plugin React app. The book button opens the Radius Booking booking form in a
 * modal: the form root is injected on click so only the opened service mounts
 * a React app, and the Radius Booking site bundle picks it up through its own
 * MutationObserver. If the Radius Booking model is unavailable the original
 * plugin markup is printed as a fallback so nothing disappears from the page.
 *
 * @var array  $settings       Widget settings.
 * @var string $booking_markup Radius Booking service list mount markup.
 * @var string $wrapper_class  Nayar wrapper classes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wrapper_class  = isset( $wrapper_class ) ? $wrapper_class : 'nayar-booking-service';
$booking_markup = isset( $booking_markup ) ? $booking_markup : '';
$settings       = isset( $settings ) && is_array( $settings ) ? $settings : [];

$nayar_services  = [];
$nayar_has_model = class_exists( '\RadiusTheme\RadiusBooking\Models\Service' );

if ( $nayar_has_model ) {
	$nayar_per_page = isset( $settings['per_page'] ) ? absint( $settings['per_page'] ) : 9;
	$nayar_per_page = $nayar_per_page > 0 ? $nayar_per_page : 9;
	$nayar_category = isset( $settings['category'] ) ? absint( $settings['category'] ) : 0;

	$nayar_query = \RadiusTheme\RadiusBooking\Models\Service::query()
		->where( 'status', '=', 'visible' )
		->where( 'is_visible', '=', 1 );

	if ( $nayar_category ) {
		$nayar_query->where( 'category_id', '=', $nayar_category );
	}

	$nayar_services = $nayar_query
		->orderBy( 'position', 'ASC' )
		->orderBy( 'id', 'ASC' )
		->limit( $nayar_per_page )
		->get();
}

/**
 * Currency symbol used in front of every price.
 */
$nayar_currency = function_exists( 'get_rtrb_currency_symbol' ) ? get_rtrb_currency_symbol() : '';

/**
 * Book button label — reuses the Radius Booking "Button Text" control.
 */
$nayar_button_text = ! empty( $settings['button_text'] ) ? $settings['button_text'] : esc_html__( 'Book Now', 'nayar-core' );

if ( empty( $nayar_services ) ) {
	// Nothing to render from the database — keep the plugin output.
	?>
	<div class="<?php echo esc_attr( $wrapper_class ); ?>">
		<div class="nayar-booking-service__inner">
			<?php echo $booking_markup; ?>
		</div>
	</div>
	<?php
	return;
}

/**
 * Booking flow the modal form starts with — same resolution as the
 * `[radius_booking_form]` shortcode.
 */
$nayar_flow = 'service_first';

if ( class_exists( '\RadiusTheme\RadiusBooking\Helpers\SettingsHelper' ) ) {
	$nayar_logic = \RadiusTheme\RadiusBooking\Helpers\SettingsHelper::get_setting( 'logic' );
	$nayar_flow  = ! empty( $nayar_logic['bookingFlow'] ) ? $nayar_logic['bookingFlow'] : $nayar_flow;
}

if ( function_exists( 'rtrb_effective_booking_flow' ) ) {
	$nayar_flow = rtrb_effective_booking_flow( $nayar_flow );
}

/*
 * Base grid layout + the click handler that opens the booking modal. Printed
 * once per page: the column count itself comes from the responsive
 * `nayar_columns` Elementor control, which prints its own selector CSS.
 */
if ( ! defined( 'NAYAR_BOOKING_SERVICE_ASSETS' ) ) {
	define( 'NAYAR_BOOKING_SERVICE_ASSETS', true );
	?>
	<style>
		.nayar-booking-service__inner{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:24px}
		.nayar-booking-service__modal{display:none;position:fixed;inset:0;z-index:999999;background:rgba(0,0,0,.6);align-items:center;justify-content:center;padding:20px}
		@keyframes rtrb-spin{to{transform:rotate(360deg)}}
	</style>
	<script>
	(function(){
		document.addEventListener('click', function(event){
			var button = event.target.closest('.nayar-booking-service__btn');

			if ( ! button ) {
				return;
			}

			var wrapper = button.closest('.nayar-booking-service');
			var modal   = wrapper && wrapper.querySelector('.nayar-booking-service__modal');

			if ( ! modal ) {
				return;
			}

			var mount = modal.querySelector('.nayar-booking-service__modal-inner');
			var root  = mount.firstElementChild;

			// Drop the previous form so the modal always opens on the clicked service.
			if ( root && root._rtrbRoot ) {
				root._rtrbRoot.unmount();
			}

			mount.innerHTML = '';

			// The Radius Booking site bundle observes the DOM and mounts any
			// `.rt-radius-booking-form` node that appears.
			var form = document.createElement('div');
			form.className = 'rtrb-root rt-radius-booking-form has-modal';
			form.setAttribute('data-service-id', button.getAttribute('data-service-id') || '');
			form.setAttribute('data-flow', button.getAttribute('data-flow') || 'service_first');
			mount.appendChild(form);

			modal.style.display = 'flex';
			document.body.style.overflow = 'hidden';
		});
	})();
	</script>
	<?php
}
?>
<div class="<?php echo esc_attr( $wrapper_class ); ?> rt-custom-booking-service">
	<div class="nayar-booking-service__inner">
		<?php foreach ( $nayar_services as $nayar_service ) : ?>
			<?php
            error_log( print_r( $nayar_service, true )."\n",  3, __DIR__.'/log.txt');
			$nayar_id    = isset( $nayar_service->id ) ? (int) $nayar_service->id : 0;
			$nayar_title = isset( $nayar_service->name ) ? $nayar_service->name : '';
			$nayar_image = isset( $nayar_service->picture_full_path ) ? $nayar_service->picture_full_path : '';
			$nayar_price = isset( $nayar_service->price ) ? (float) $nayar_service->price : 0;
			$nayar_price = $nayar_currency . number_format_i18n( $nayar_price, 2 );
			?>
			<div class="booking-service-item">
				<?php if ( $nayar_image ) : ?>
					<img class="booking-img" src="<?php echo esc_url( $nayar_image ); ?>" alt="<?php echo esc_attr( $nayar_title ); ?>" />
				<?php endif; ?>
                <?php if ( $nayar_price ) : ?>
				<span class="booking-price"><?php echo esc_html( $nayar_price ); ?></span>
                <?php endif; ?>
                <?php if ( $nayar_title && $nayar_id ) : ?>
                <div class="rt-button">
                    <button type="button" class="rt-primary-btn btn button-2  nayar-booking-service__btn" data-service-id="<?php echo esc_attr( $nayar_id ); ?>" data-flow="<?php echo esc_attr( $nayar_flow ); ?>"><?php echo esc_html( $nayar_title ); ?>
                        <span class="btn-icon"> <i class="icon-rt-arrow-right-1"></i></span>
                    </button>
                </div>
                <?php endif; ?>
            </div>
		<?php endforeach; ?>
	</div>
	<div class="nayar-booking-service__modal rtrb-shortcode-modal">
		<div class="nayar-booking-service__modal-inner"></div>
	</div>
</div>
