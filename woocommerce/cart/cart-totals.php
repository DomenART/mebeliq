<?php
defined('ABSPATH') || exit;
?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <div><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
            <div data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
        </div>
    <?php endforeach; ?>

    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

        <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

        <?php wc_cart_totals_shipping_html(); ?>

        <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

    <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

        <div class="shipping">
            <div class="shipping__title"><?php _e( 'Shipping', 'woocommerce' ); ?></div>
            <div class="shipping__body" data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></div>
        </div>

    <?php endif; ?>

    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <div class="fee">
            <div><?php echo esc_html( $fee->name ); ?></div>
            <div data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></div>
        </div>
    <?php endforeach; ?>

    <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) :
        $taxable_address = WC()->customer->get_taxable_address();
        $estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
            ? sprintf( ' <small>' . __( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
            : '';

        if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
            <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                <div class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                    <div class="tax-rate__title"><?php echo esc_html( $tax->label ) . $estimated_text; ?></div>
                    <div class="tax-rate__body" data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="tax-total">
                <div class="tax-total__title"><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></div>
                <div class="tax-total__body" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

    <div class="order-total">
        <div class="order-total__title">Стоимость товаров:</div>
        <div class="order-total__body" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></div>
    </div>

    <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

    <div class="wc-proceed-to-checkout">
        <a class="checkout-button" href="<?php the_permalink(get_option('woocommerce_shop_page_id')) ?>">Продолжить покупки</a>
        <button class="checkout-button checkout-button_success js-cart-accordion-next" type="button">Оформить заказ</button>
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
