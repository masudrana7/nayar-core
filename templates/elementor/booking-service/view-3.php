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
 * @var array  $category_names Category names keyed by id (Category Badge).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$wrapper_class  = isset( $wrapper_class ) ? $wrapper_class : 'nayar-booking-service';
$booking_markup = isset( $booking_markup ) ? $booking_markup : '';
$settings       = isset( $settings ) && is_array( $settings ) ? $settings : [];
$category_names = isset( $category_names ) && is_array( $category_names ) ? $category_names : [];

/**
 * Radius Booking "Display Options" switches.
 */
$nayar_show_image    = ! isset( $settings['show_image'] ) || 'yes' === $settings['show_image'];
$nayar_show_price    = ! isset( $settings['show_price'] ) || 'yes' === $settings['show_price'];
$nayar_show_desc     = ! isset( $settings['show_description'] ) || 'yes' === $settings['show_description'];
$nayar_show_duration = ! empty( $settings['show_duration'] ) && 'yes' === $settings['show_duration'];

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

$nayar_button_text = ! empty( $settings['nayar_button_text'] ) ? $settings['nayar_button_text'] : esc_html__( 'Book Your Slot', 'nayar-core' );


/**
 * Max words for the service description — 0 hides it.
 */
$nayar_desc_limit = isset( $settings['nayar_description_limit'] ) && '' !== $settings['nayar_description_limit'] ? absint( $settings['nayar_description_limit'] ) : 20;

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
        .nayar-booking-service .booking-meta{display:flex;flex-wrap:wrap;align-items:center;gap:8px 16px;margin:0 0 12px}.nayar-booking-service .booking-category{display:inline-block;padding:4px 12px;border-radius:100px;background-color:var(--rt-primary-color);color:#fff;font-size:12px;line-height:1.4}.nayar-booking-service .booking-duration{display:inline-flex;align-items:center;gap:6px;font-size:14px}.nayar-booking-service .booking-duration svg{width:14px;height:14px;flex-shrink:0}
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
    <?php
    \RT\NayarCore\Helper\Fns::get_template(
        'elementor/booking-service/category-filter',
        [
            'settings' => $settings,
            'services' => $nayar_services,
        ]
    );
    ?>
    <div class="nayar-booking-service__inner">
        <?php foreach ( $nayar_services as $nayar_service ) : ?>
            <?php
            $nayar_id    = isset( $nayar_service->id ) ? (int) $nayar_service->id : 0;
            $nayar_cat   = isset( $nayar_service->category_id ) ? (int) $nayar_service->category_id : 0;
            $nayar_title = isset( $nayar_service->name ) ? $nayar_service->name : '';
            $nayar_image = $nayar_show_image && isset( $nayar_service->picture_full_path ) ? $nayar_service->picture_full_path : '';
            $nayar_price = isset( $nayar_service->price ) ? (float) $nayar_service->price : 0;
            $nayar_price = $nayar_show_price ? $nayar_currency . number_format_i18n( $nayar_price, 2 ) : '';
            $nayar_cat_name = isset( $category_names[ $nayar_cat ] ) ? $category_names[ $nayar_cat ] : '';
            $nayar_minutes  = $nayar_show_duration && isset( $nayar_service->duration ) ? (int) floor( absint( $nayar_service->duration ) / 60 ) : 0; // Stored in seconds.
            $nayar_duration = '';

            if ( $nayar_minutes ) {
                $nayar_hours    = floor( $nayar_minutes / 60 );
                $nayar_mins     = $nayar_minutes % 60;
                /* translators: %d: hours */
                $nayar_duration = $nayar_hours ? sprintf( esc_html__( '%d hr', 'nayar-core' ), $nayar_hours ) : '';
                /* translators: %d: minutes */
                $nayar_duration = trim( $nayar_duration . ( $nayar_mins ? ' ' . sprintf( esc_html__( '%d min', 'nayar-core' ), $nayar_mins ) : '' ) );
            }
            $nayar_desc  = $nayar_show_desc && isset( $nayar_service->description ) && $nayar_desc_limit ? wp_trim_words( wp_strip_all_tags( $nayar_service->description ), $nayar_desc_limit, '' ) : '';
            ?>
            <div class="booking-service-item" data-category="<?php echo esc_attr( 'cat-' . $nayar_cat ); ?>">
                <?php if ( $nayar_image || $nayar_price ) : ?>
                <div class="booking-img-inner">
                        <div class="booking-img-wrapper">
                        <?php if ( $nayar_image ) : ?>
                            <img class="booking-img" src="<?php echo esc_url( $nayar_image ); ?>" alt="<?php echo esc_attr( $nayar_title ); ?>" />
                        <?php endif; ?>
                        </div>
                    <?php if ( $nayar_price ) : ?>
                        <span class="booking-price"><?php echo esc_html( $nayar_price ); ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ( $nayar_title ) : ?>
                    <h3 class="booking-title"><?php echo esc_html( $nayar_title ); ?></h3>
                <?php endif; ?>
                <?php if ( $nayar_cat_name || $nayar_duration ) : ?>
                    <div class="booking-meta">
                        <?php if ( $nayar_cat_name ) : ?>
                            <span class="booking-category"><?php echo esc_html( $nayar_cat_name ); ?></span>
                        <?php endif; ?>
                        <?php if ( $nayar_duration ) : ?>
                            <span class="booking-duration"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg><?php echo esc_html( $nayar_duration ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ( $nayar_desc ) : ?>
                    <p class="booking-desc"><?php echo esc_html( $nayar_desc ); ?></p>
                <?php endif; ?>
                <?php if ( $nayar_button_text && $nayar_id ) : ?>
                    <div class="rt-button">
                        <button type="button" class="rt-primary-btn btn button-2  nayar-booking-service__btn" data-service-id="<?php echo esc_attr( $nayar_id ); ?>" data-flow="<?php echo esc_attr( $nayar_flow ); ?>"><?php echo esc_html( $nayar_button_text ); ?>
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
