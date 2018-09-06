<?php
/*
Template Name: Корзина
*/
?>
<!DOCTYPE html>
<html>
    <head>
        <?php get_template_part('partials/head'); ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="header-wrap">
                <?php get_template_part('partials/header'); ?>
            </div>

            <div class="uk-container">
                <div class="page-breadcrumb">
                    <?php woocommerce_breadcrumb() ?>
                </div>

                <?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>
                    <div class="page-content">
                        <?php the_content(); ?>
                    </div>
                    <ul class="cart-accordion uk-accordion js-cart-accordion">
                        <?php if (empty($_REQUEST['key'])) : ?>
                            <li class="uk-open">
                                <div class="cart-accordion__title uk-accordion-title">Корзина</div>
                                <div class="cart-accordion__content uk-accordion-content">
                                    <?php echo do_shortcode('[woocommerce_cart]'); ?>
                                </div>
                            </li>
                            <li class="uk-hidden">
                                <div class="cart-accordion__title uk-accordion-title">Оформление заказа</div>
                                <div class="cart-accordion__content uk-accordion-content">
                                    <?php echo do_shortcode('[woocommerce_checkout]'); ?>
                                </div>
                            </li>
                            <li class="uk-hidden">
                                <div class="cart-accordion__title uk-accordion-title">Статус заказа</div>
                                <div class="cart-accordion__content uk-accordion-content">
                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat proident.</p>
                                </div>
                            </li>
                        <?php else: ?>
                            <li>
                                <div class="cart-accordion__title uk-accordion-title">Корзина</div>
                                <div class="cart-accordion__content uk-accordion-content uk-hidden">
                                    <?php echo do_shortcode('[woocommerce_cart]'); ?>
                                </div>
                            </li>
                            <li>
                                <div class="cart-accordion__title uk-accordion-title">Оформление заказа</div>
                                <div class="cart-accordion__content uk-accordion-content uk-hidden">
                                    <p>Заказ пошел в обработку.</p>
                                </div>
                            </li>
                            <li class="uk-open">
                                <div class="cart-accordion__title uk-accordion-title">Статус заказа</div>
                                <div class="cart-accordion__content uk-accordion-content">
                                    <?php echo do_shortcode('[woocommerce_checkout]'); ?>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endwhile; else: ?>
                    <div class="page-content">
                        <p>Извините, ничего не найдено.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php get_template_part('partials/footer'); ?>
        </div>
    </body>
</html>