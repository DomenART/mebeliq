<div class="uk-container container-product">
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

    $prices = getProductPrices($product);
    $categories = get_the_terms( $product->id, 'product_cat' );
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

        <form action="" method="post" enctype="multipart/form-data"<?php if ($product->get_type() === 'variable'): ?> data-product_variations="<?php echo htmlspecialchars(wp_json_encode($product->get_available_variations())); // WPCS: XSS ok. ?>"<?php endif; ?>>
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
                        $by_name = array();
                        $types = get_field('product_attribute_types', 'option');
                        foreach ($types as $type) {
                            $by_name['pa_' . $type['field']] = $type;
                        }
                        foreach ($product->get_variation_attributes() as $attribute_name => $options) {
                            $key = 'attribute_' . sanitize_title($attribute_name);
                            $type = $by_name[$attribute_name]['type'] ?: 'select';
                            $switch = $by_name[$attribute_name]['switch'] ?: false;
                            $alt = $by_name[$attribute_name]['alt'] ?: wc_attribute_label($attribute_name);
                            $default = $product->get_variation_default_attribute( sanitize_title($attribute_name) );
                            $checked = isset($_REQUEST[$key]) ? wc_clean( urldecode( wp_unslash( $_REQUEST[ $key ] ) ) ) : $product->get_variation_default_attribute( sanitize_title($attribute_name) );
                            $terms = wc_get_product_terms($product->get_id(), $attribute_name, array('fields' => 'all'));
                            echo '<div class="product-attribute product-attribute_' . $attribute_name . ' attribute-' . $type . '">';
                            if ($switch) {
                                echo '<div class="attribute-toggle' . (!($checked === $default) ? ' attribute-toggle_open' : '') . '" data-default="' . $default . '">';
                                echo '<div class="attribute-toggle-switcher">';
                                echo '<div class="attribute-toggle-switcher__label">' . $alt . '</div>';
                                echo '<div class="attribute-toggle-switcher__values">';
                                echo '<div class="attribute-toggle-switcher__value attribute-toggle-switcher__value_no">Нет</div>';
                                echo '<div class="attribute-toggle-switcher__value attribute-toggle-switcher__value_yes">Да</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="attribute-toggle-values">';
                            }
                            switch ($type) {
                                case 'image':
                                    echo '<div class="attribute-image">';
                                    echo '<div class="attribute-image__values">';
                                    foreach ($terms as $term) {
                                        $image = get_field('image', $attribute_name . '_' . $term->term_id);
                                        $hidden = $by_name[$attribute_name]['hide_default'] && $checked === $term->slug;
                                        echo '<label title="' . $term->name . '" class="attribute-image__value attribute-image__value_' . $key . '"' . ($hidden ? ' style="display: none"' : '') . '>';
                                        echo '<img src="' . $image['url'] . '">';
                                        echo '<input type="radio" class="input-radio" name="' . $key . '" id="' . $key . '" value="' . $term->slug . '" ' . ($checked === $term->slug ? 'checked' : '') . '><span></span>';
                                        echo '</label>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                    break;
                                case 'color':
                                    echo '<div class="attribute-color__values">';
                                    foreach ($terms as $term) {
                                        $color = get_field('color', $attribute_name . '_' . $term->term_id);
                                        echo '<label title="' . $term->name . '" class="attribute-color__value">';
                                        echo '<input type="radio" name="' . $key . '" value="' . $term->slug . '" ' . ($checked === $term->slug ? 'checked' : '') . '><span style="background-color: ' . $color . '">' . $term->name . '</span>';
                                        echo '</label>';
                                    }
                                    echo '</div>';
                                    break;
                                case 'pattern':
                                    echo '<div class="attribute-pattern__values">';
                                    foreach ($terms as $term) {
                                        $image = get_field('image', $attribute_name . '_' . $term->term_id);
                                        echo '<label title="' . $term->name . '" class="attribute-pattern__value">';
                                        echo '<input type="radio" name="' . $key . '" value="' . $term->slug . '" ' . ($checked === $term->slug ? 'checked' : '') . '><span style=\'background-image: url("' . $image['url'] . '")\'>' . $term->name . '</span>';
                                        echo '</label>';
                                        echo '<div uk-dropdown="pos: top-center; delay-hide: 200" class="attribute-pattern__dropdown" style=\'background-image: url("' . $image['url'] . '")\'></div>';
                                    }
                                    echo '</div>';
                                    break;
                                case 'radio':
                                    echo '<label class="attribute-radio__label" for="' . $key . '">' . wc_attribute_label($attribute_name) . '</label>';
                                    echo '<div class="attribute-radio__values">';
                                    foreach ($terms as $term) {
                                        echo '<label class="attribute-radio__value"><input type="radio" name="' . $key . '" value="' . $term->slug . '" ' . ($checked === $term->slug ? 'checked' : '') . '><span></span> '. $term->name . '</label>';
                                    }
                                    echo '</div>';
                                    break;
                                case 'select':
                                default:
                                    $format = '<label class="attribute-select__label" for="%s">%s</label>';
                                    echo sprintf($format, esc_attr(sanitize_title($attribute_name)), wc_attribute_label($attribute_name));
                                    echo '<div class="attribute-select__values">';
                                    wc_dropdown_variation_attribute_options(array(
                                        'options'   => $options,
                                        'attribute' => $attribute_name,
                                        'product'   => $product,
                                    ));
                                    echo '</div>';
                                    break;
                            }
                            if ($switch) {
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        echo '</div>';
                    endif; ?>
                </div>
            </div>

            <div class="product-price">
                <?php if ($product->is_on_sale() && $prices['min_reg_price'] === $prices['max_reg_price']): ?>
                <div class="product-price__old">
                    старая цена:
                    <?php echo wc_price($prices['max_reg_price']) ?>
                </div>
                <?php endif; ?>
                <div class="product-price__current">
                    <div class="product-add">
                        <div class="product-add__label">в корзину:</div>
                        <button type="submit" class="product-add__value">
                            <span class="js-product-price">
                            <?php if ($prices['min_price'] !== $prices['max_price']): ?>от&nbsp;<?php endif; ?>
                            <?php echo wc_price($prices['min_price']); ?>
                            </span>

                            <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()) ?>" />
                            <input name="product_id" value="<?php echo absint($product->get_id()) ?>" type="hidden">
                            <input name="variation_id" class="variation_id" value="0" type="hidden">
                            <span class="product-add__cart"></span>
                        </button>
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
</div>

<?php if ($categories) : ?>
    <!--noindex-->
    <section class="product-content section-content">
        <div class="uk-container">
            <div class="section-content__title">
                <span><?php echo current($categories)->name ?></span>
            </div>
            <div class="section-content__text">
                <?php echo current($categories)->description ?>
            </div>
            <div class="section-more">
                <a href="#question" class="section-more__link">
                    <span>Задать свой вопрос... </span>
                    <img src="<?php echo get_bloginfo('template_url') ?>/dist/img/icon-question.png" alt="">
                </a>
            </div>
        </div>
    </section>
    <!--/noindex-->
<?php endif; ?>
