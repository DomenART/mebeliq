<?php
defined('ABSPATH') || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
    return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

    <?php if ( $checkout->get_checkout_fields() ) : ?>

        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

        <div class="uk-grid" id="customer_details" uk-grid>
            <div class="uk-width-1-2">
                <?php do_action( 'woocommerce_checkout_billing' ); ?>
            </div>

            <div class="uk-width-1-2">
                <?php do_action( 'woocommerce_checkout_shipping' ); ?>

                <!--<h3 id="order_review_heading">--><?php //_e( 'Your order', 'woocommerce' ); ?><!--</h3>-->

                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>

                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
            </div>
        </div>

        <div class="place-order">
            <?php wc_get_template( 'checkout/terms.php' ); ?>

            <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

            <div class="order-actions">
                <?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="checkout-button checkout-button_success js-cart-accordion-next" name="woocommerce_checkout_place_order" id="place_order" value="Подтвердить" data-value="Подтвердить">Подтвердить</button>' ); // @codingStandardsIgnoreLine ?>

                <button class="checkout-button js-cart-go_to_cart" type="button">Вернуться к корзине</button>
            </div>

            <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

            <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
        </div>

        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

    <?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
