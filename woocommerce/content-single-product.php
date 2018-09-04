<?php
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

global $product;
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
    <div class="product__breadcrumb">
        <?php woocommerce_breadcrumb() ?>
    </div>

    <h1 class="product__title"><?php the_title() ?></h1>

    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    do_action( 'woocommerce_before_single_product_summary' );
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="uk-grid" uk-grid>
            <div class="uk-width-3-5@s">
                <?php wc_get_template('single-product/product-image.php'); ?>
            </div>
            <div class="uk-width-2-5@s">
                <?php
                    /**
                     * Hook: woocommerce_single_product_summary.
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     * @hooked WC_Structured_Data::generate_product_data() - 60
                     */
                    do_action( 'woocommerce_single_product_summary' );
                ?>
                <?php if ($product->get_type() === 'variable'):
                    echo '<div class="product__attributes">';
                    foreach ($product->get_variation_attributes() as $attribute_name => $options) {
                        if ($attribute_name === 'pa_color') {
                            echo '<div class="attribute-color">';
                            echo '<div class="attribute-color__values">';
                            $terms = wc_get_product_terms($product->get_id(), $attribute_name, array('fields' => 'all'));
                            $key = 'attribute_' . sanitize_title($attribute_name);
                            $checked = isset($_REQUEST[$key]) ? wc_clean( urldecode( wp_unslash( $_REQUEST[ $key ] ) ) ) : $product->get_variation_default_attribute( $key );
                            foreach ($terms as $term) {
                                $color = get_field('color', 'pa_color_' . $term->term_id);
                                echo '<label title="' . $term->name . '" class="attribute-color__value">';
                                echo '<input type="radio" name="' . $key . '" value="' . $term->slug . '" ' . ($checked === $term->slug ? 'checked' : '') . '><span style="background-color: ' . $color . '">' . $term->name . '</span>';
                                echo '</label>';
                            }
                            echo '</div>';
                            echo '</div>';
                        } else if (count($options) === 2 && $options[0] === 'da' && $options[1] === 'net') {
                            echo '<div class="attribute-radio">';
                                $key = 'attribute_' . esc_attr(sanitize_title($attribute_name));
                                $checked = isset($_REQUEST[$key]) ? wc_clean( urldecode( wp_unslash( $_REQUEST[ $key ] ) ) ) : $product->get_variation_default_attribute( $key );
                                echo '<label class="attribute-radio__label" for="' . $key . '">' . wc_attribute_label($attribute_name) . '</label>';
                                echo '<div class="attribute-radio__values">';
                                echo '<label class="attribute-radio__value">Нет <input type="radio" name="' . $key . '" value="net" ' . ($checked === 'net' ? 'checked' : '') . '><span></span></label>';
                                echo '<label class="attribute-radio__value">Да <input type="radio" name="' . $key . '" value="da" ' . ($checked === 'da' ? 'checked' : '') . '><span></span></label>';
                                echo '</div>';
                                echo '</div>';
                        } else {
                            echo '<div class="attribute-select">';
                            $format = '<label class="attribute-select__label" for="%s">%s</label>';
                            echo sprintf($format, esc_attr(sanitize_title($attribute_name)), wc_attribute_label($attribute_name));
                            echo '<div class="attribute-select__values">';
                            wc_dropdown_variation_attribute_options(array(
                                'options'   => $options,
                                'attribute' => $attribute_name,
                                'product'   => $product,
                            ));
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                endif; ?>
            </div>
        </div>

        <?php
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
        <div class="product-price">
            <?php if ($product->is_on_sale() && $min_reg_price === $max_reg_price): ?>
            <div class="product-price__old">
                старая цена:
                <?php echo wc_price($max_reg_price) ?>
            </div>
            <?php endif; ?>
            <div class="product-price__current">
                <div class="product-add">
                    <div class="product-add__label">в корзину:</div>
                    <div class="product-add__value">
                        <?php if ($min_price !== $max_price): ?>от <?php endif; ?>
                        <?php echo wc_price($min_price); ?>

                        <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()) ?>" />
                        <input name="product_id" value="<?php echo absint($product->get_id()) ?>" type="hidden">
                        <input name="variation_id" class="variation_id" value="0" type="hidden">
                        <button type="submit" class="product-add__cart"></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
     do_action( 'woocommerce_after_single_product_summary' );
    ?>

    <div class="product-backward">
        <a href="<?php the_permalink(get_option('woocommerce_shop_page_id')) ?>">Назад к каталогу...</a>
    </div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
