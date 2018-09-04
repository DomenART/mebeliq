<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_mini_cart' ); ?>

<a href="<?php echo esc_url(wc_get_cart_url()) ?>" class="header-cart">
    <span class="header-cart__icon"></span>
    <span class="header-cart__info">
        <?php if ( ! WC()->cart->is_empty() ) : ?>
        <span class="header-cart__count">
            <?php echo num_decline(count(WC()->cart->get_cart()), 'товар', 'товара', 'товаров') ?><br>
        </span>
        <span class="header-cart__price">
            <?php echo WC()->cart->get_cart_subtotal(); ?>
        </span>
        <?php else : ?>
        <span><?php _e( 'No products in the cart.', 'woocommerce' ); ?></span>
        <?php endif; ?>
    </span>
</a>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
