<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $product;

$prices = getProductPrices($product);
?>
<div class="price-card">
    <div class="price-card__price">
        <?php if ($prices['min_price'] !== $prices['max_price']): ?>от <?php endif; ?>
        <?php echo wc_price($prices['min_price']); ?>
    </div>

    <?php if ($product->is_on_sale() && $prices['min_reg_price'] === $prices['max_reg_price']): ?>
        <div class="price-card__old">старая цена: <span><?php echo number_format($prices['max_reg_price'], 0, ',', ' ') ?></span></div>
    <?php endif; ?>
</div>