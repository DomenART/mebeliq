<?php

$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

    <div class="product-tabs">
        <a href="#question" class="product-tabs__question">Задать вопрос...</a>
        <ul class="js-product-tabs uk-hidden">
            <?php foreach ( $tabs as $key => $tab ) : ?>
                <li data-title="<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>">
                    <?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php endif; ?>
