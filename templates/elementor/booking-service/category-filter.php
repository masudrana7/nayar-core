<?php
//phpcs:disable
/**
 * Booking Service — category isotope filter bar.
 *
 * Override from the theme: nayar-core/elementor/booking-service/category-filter.php
 *
 * Shared by view-1, view-2 and view-3 when the "Category Isotope" switch is on.
 * Clicking a category hides/shows the matching `.booking-service-item` cards
 * (matched by their `data-category`) with an isotope like scale + fade
 * animation. Vanilla JS, no extra library needed.
 *
 * @var array $settings Widget settings.
 * @var array $services Rendered Radius Booking services.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$settings = isset( $settings ) && is_array( $settings ) ? $settings : [];
$services = isset( $services ) && is_array( $services ) ? $services : [];

// Off, or the widget is already limited to a single category.
if ( empty( $settings['nayar_category_isotope'] ) || 'yes' !== $settings['nayar_category_isotope'] || ! empty( $settings['category'] ) || ! $services ) {
    return;
}

$nayar_show_all = ! isset( $settings['nayar_filter_show_all'] ) || 'yes' === $settings['nayar_filter_show_all'];
$nayar_all_text = ! empty( $settings['nayar_filter_all_text'] ) ? $settings['nayar_filter_all_text'] : esc_html__( 'All', 'nayar-core' );

/**
 * Filter categories — only the ones owning at least one rendered service, kept
 * in the Radius Booking category order.
 */
$nayar_filters  = [];
$nayar_used_ids = [];

foreach ( $services as $nayar_service ) {
    if ( ! empty( $nayar_service->category_id ) ) {
        $nayar_used_ids[ (int) $nayar_service->category_id ] = true;
    }
}

if ( $nayar_used_ids && class_exists( '\RadiusTheme\RadiusBooking\Models\Category' ) ) {
    $nayar_categories = \RadiusTheme\RadiusBooking\Models\Category::query()
        ->orderBy( 'order_number', 'ASC' )
        ->orderBy( 'id', 'ASC' )
        ->get();

    foreach ( $nayar_categories as $nayar_cat ) {
        $nayar_cat_id = isset( $nayar_cat->id ) ? (int) $nayar_cat->id : 0;

        if ( $nayar_cat_id && isset( $nayar_used_ids[ $nayar_cat_id ] ) && ! empty( $nayar_cat->name ) ) {
            $nayar_filters[ $nayar_cat_id ] = $nayar_cat->name;
        }
    }
}

if ( count( $nayar_filters ) < 2 ) {
    return;
}

/*
 * Filter styles + click handler. Printed once per page and delegated, so it
 * also works for widgets rendered later (Elementor editor preview).
 */
if ( ! defined( 'NAYAR_BOOKING_SERVICE_FILTER_ASSETS' ) ) {
    define( 'NAYAR_BOOKING_SERVICE_FILTER_ASSETS', true );
    ?>
    <style>
        .nayar-booking-service__filter{display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin:0 0 40px}
        .nayar-booking-service .nayar-booking-service__filter-btn{cursor:pointer;padding:8px 20px;border:1px solid #e5e7eb;border-radius:100px;background-color:#fff;color:#4b5563;line-height:1.4;box-shadow:none;transition:all .3s ease}
        .nayar-booking-service .nayar-booking-service__filter-btn.active{background-color:var(--rt-primary-color);border-color:var(--rt-primary-color);color:#fff}
        .nayar-booking-service--isotope .booking-service-item.is-hidden{display:none}
    </style>
    <script>
        (function(){
            var EASE    = 'cubic-bezier(.22,1,.36,1)';
            var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var canAnim = 'function' === typeof Element.prototype.animate && ! reduced;

            function stop(item){
                if ( item.getAnimations ) {
                    item.getAnimations().forEach(function(anim){ anim.cancel(); });
                }
            }

            function run(wrapper, filter){
                var items    = Array.prototype.slice.call(wrapper.querySelectorAll('.nayar-booking-service__inner > .booking-service-item'));
                var leaving  = [];
                var entering = [];
                var staying  = [];

                items.forEach(function(item){
                    var match   = '*' === filter || item.getAttribute('data-category') === filter;
                    var visible = ! item.classList.contains('is-hidden');

                    stop(item);

                    if ( visible && ! match ) {
                        leaving.push(item);
                    } else if ( ! visible && match ) {
                        entering.push(item);
                    } else if ( visible ) {
                        staying.push(item);
                    }
                });

                if ( ! canAnim ) {
                    leaving.forEach(function(item){ item.classList.add('is-hidden'); });
                    entering.forEach(function(item){ item.classList.remove('is-hidden'); });
                    return;
                }

                // A newer click wins: stale phases check this token and bail.
                var token = wrapper._nayarFilterRun = ( wrapper._nayarFilterRun || 0 ) + 1;

                // Phase 1 — cards that no longer match shrink and fade out.
                leaving.forEach(function(item){
                    item.animate(
                        [ { opacity: 1, transform: 'scale(1)' }, { opacity: 0, transform: 'scale(.8)' } ],
                        { duration: 260, easing: 'ease-in', fill: 'forwards' }
                    );
                });

                setTimeout(function(){
                    if ( token !== wrapper._nayarFilterRun ) {
                        return;
                    }

                    // Phase 2 — FLIP: remember where staying cards are, reflow, then glide them over.
                    var first = staying.map(function(item){ return item.getBoundingClientRect(); });

                    leaving.forEach(function(item){
                        item.classList.add('is-hidden');
                        stop(item);
                    });
                    entering.forEach(function(item){ item.classList.remove('is-hidden'); });

                    staying.forEach(function(item, index){
                        var last = item.getBoundingClientRect();
                        var dx   = first[ index ].left - last.left;
                        var dy   = first[ index ].top - last.top;

                        if ( dx || dy ) {
                            item.animate(
                                [ { transform: 'translate(' + dx + 'px,' + dy + 'px)' }, { transform: 'translate(0,0)' } ],
                                { duration: 550, easing: EASE }
                            );
                        }
                    });

                    // New cards rise in one after another.
                    entering.forEach(function(item, index){
                        item.animate(
                            [ { opacity: 0, transform: 'translateY(40px) scale(.92)' }, { opacity: 1, transform: 'translateY(0) scale(1)' } ],
                            { duration: 600, delay: index * 70, easing: EASE, fill: 'backwards' }
                        );
                    });
                }, leaving.length ? 260 : 0);
            }

            document.addEventListener('click', function(event){
                var button  = event.target.closest('.nayar-booking-service__filter-btn');
                var wrapper = button && button.closest('.nayar-booking-service');

                if ( ! wrapper || button.classList.contains('active') && event.isTrusted ) {
                    return;
                }

                wrapper.querySelectorAll('.nayar-booking-service__filter-btn').forEach(function(item){
                    var active = item === button;
                    item.classList.toggle('active', active);
                    item.setAttribute('aria-pressed', active ? 'true' : 'false');
                });

                run(wrapper, button.getAttribute('data-filter') || '*');
            });
        })();
    </script>
    <?php
}
?>
<div class="nayar-booking-service__filter">
    <?php if ( $nayar_show_all ) : ?>
        <button type="button" class="nayar-booking-service__filter-btn active" data-filter="*" aria-pressed="true"><?php echo esc_html( $nayar_all_text ); ?></button>
    <?php endif; ?>
    <?php foreach ( $nayar_filters as $nayar_cat_id => $nayar_cat_name ) : ?>
        <?php $nayar_active = ! $nayar_show_all && array_key_first( $nayar_filters ) === $nayar_cat_id; ?>
        <button type="button" class="nayar-booking-service__filter-btn<?php echo $nayar_active ? ' active' : ''; ?>" data-filter="<?php echo esc_attr( 'cat-' . $nayar_cat_id ); ?>" aria-pressed="<?php echo $nayar_active ? 'true' : 'false'; ?>"><?php echo esc_html( $nayar_cat_name ); ?></button>
    <?php endforeach; ?>
</div>
<?php if ( ! $nayar_show_all ) : ?>
    <script>
        // No "All" button: hide the other categories (no animation) once the cards below are in the DOM.
        (function(script){
            var button = script.previousElementSibling && script.previousElementSibling.querySelector('.nayar-booking-service__filter-btn.active');
            var run    = function(){
                var wrapper = button && button.closest('.nayar-booking-service');
                var filter  = button && button.getAttribute('data-filter');

                if ( ! wrapper ) {
                    return;
                }

                wrapper.querySelectorAll('.nayar-booking-service__inner > .booking-service-item').forEach(function(item){
                    item.classList.toggle('is-hidden', item.getAttribute('data-category') !== filter);
                });
            };

            'loading' === document.readyState ? document.addEventListener('DOMContentLoaded', run) : setTimeout(run, 0);
        })(document.currentScript);
    </script>
<?php endif; ?>
