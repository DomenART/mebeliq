<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $product;

if ($product->get_type() === 'simple') {
    $min_price = $product->price;
    $max_price = $product->price;
    $min_reg_price = $product->regular_price;
    $max_reg_price = $product->regular_price;
} else {
    $prices = $product->get_variation_prices(true);
    $min_price = current($prices['price']);
    $max_price = end($prices['price']);
    $min_reg_price = current($prices['regular_price']);
    $max_reg_price = end($prices['regular_price']);
}
?>
<div class="price-card">
    <div class="price-card__price">
        <?php if ($min_price !== $max_price): ?>от <?php endif; ?>
        <?php echo wc_price($min_price); ?>
    </div>

    <?php if ($product->is_on_sale() && $min_reg_price === $max_reg_price): ?>
        <div class="price-card__old"><?php echo wc_price($max_reg_price) ?></div>
    <?php endif; ?>
</div>