<?php
global $product;
// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
$link = esc_url(apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product));
?>
<div <?php wc_product_class(); ?>>
    <div class="product-card<?php if ($product->is_on_sale()): ?> product-card_discount<?php endif; ?>">
        <div class="product-card__title">
            <a href="<?php echo $link ?>"><?php the_title() ?></a>
        </div>
        <a href="<?php echo $link ?>" class="product-card__image">
            <?php echo woocommerce_get_product_thumbnail() ?>
        </a>
        <div class="product-card__info">
            <dl class="product-card__params">
                <?php if ($length = $product->get_length()): ?>
                    <dt>Длина:</dt><dd><?php echo $length ?> см.</dd>
                <?php endif; ?>
                <?php if ($width = $product->get_width()): ?>
                    <dt>Ширина:</dt><dd><?php echo $width ?> см.</dd>
                <?php endif; ?>
                <?php if ($height = $product->get_height()): ?>
                    <dt>Высота:</dt><dd><?php echo $height ?> см.</dd>
                <?php endif; ?>
            </dl>

            <div class="product-card__buy">
                <?php wc_get_template( 'loop/price.php' ) ?>
                <?php woocommerce_template_loop_add_to_cart() ?>
            </div>
        </div>
    </div>
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
//    do_action( 'woocommerce_before_shop_loop_item' );
    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */
//    do_action( 'woocommerce_before_shop_loop_item_title' );
    /**
     * Hook: woocommerce_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     */
//    do_action( 'woocommerce_shop_loop_item_title' );
    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
//    do_action( 'woocommerce_after_shop_loop_item_title' );
    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
//    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
</div>