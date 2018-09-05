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

            <div class="uk-container uk-container-large">
                <div class="uk-grid uk-grid-large" uk-grid>
                    <div class="uk-width-1-4@m">
                        <?php
                        /**
                         * Hook: woocommerce_sidebar.
                         *
                         * @hooked woocommerce_get_sidebar - 10
                         */
                        do_action( 'woocommerce_sidebar' );
                        ?>
                    </div>

                    <div class="uk-width-3-4@m">
                        <?php
                        /**
                         * Hook: woocommerce_before_main_content.
                         *
                         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                         * @hooked woocommerce_breadcrumb - 20
                         * @hooked WC_Structured_Data::generate_website_data() - 30
                         */
                        do_action( 'woocommerce_before_main_content' );

                        if ( woocommerce_product_loop() ) {

                            /**
                             * Hook: woocommerce_before_shop_loop.
                             *
                             * @hooked wc_print_notices - 10
                             * @hooked woocommerce_result_count - 20
                             * @hooked woocommerce_catalog_ordering - 30
                             */
                            do_action( 'woocommerce_before_shop_loop' );
                            ?>

                            <div class="category-heading">
                                <div class="category-heading__breadcrumb">
                                    <?php woocommerce_breadcrumb() ?>
                                </div>
                                <div class="category-heading__ordering">
                                    <?php woocommerce_catalog_ordering() ?>
                                </div>
                            </div>

                            <?php

                            woocommerce_product_loop_start();

                            if ( wc_get_loop_prop( 'total' ) ) {
                                while ( have_posts() ) {
                                    the_post();

                                    /**
                                     * Hook: woocommerce_shop_loop.
                                     *
                                     * @hooked WC_Structured_Data::generate_product_data() - 10
                                     */
                                    do_action( 'woocommerce_shop_loop' );

                                    wc_get_template_part( 'content', 'product' );
                                }
                            }

                            woocommerce_product_loop_end();

                            /**
                             * Hook: woocommerce_after_shop_loop.
                             *
                             * @hooked woocommerce_pagination - 10
                             */
                            do_action( 'woocommerce_after_shop_loop' );
                        } else {
                            /**
                             * Hook: woocommerce_no_products_found.
                             *
                             * @hooked wc_no_products_found - 10
                             */
                            do_action( 'woocommerce_no_products_found' );
                        }

                        /**
                         * Hook: woocommerce_after_main_content.
                         *
                         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                         */
                        do_action( 'woocommerce_after_main_content' );
                        ?>
                    </div>
                </div>
            </div>

            <section class="product-content section-content">
                <div class="uk-container">
                    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                        <div class="section-content__title"><span><?php woocommerce_page_title(); ?></span></div>
                    <?php endif; ?>
                    <div class="section-content__text">
                        <?php
                        /**
                         * Hook: woocommerce_archive_description.
                         *
                         * @hooked woocommerce_taxonomy_archive_description - 10
                         * @hooked woocommerce_product_archive_description - 10
                         */
                        do_action( 'woocommerce_archive_description' );
                        ?>
                    </div>
                    <div class="section-more">
                        <a href="<?php the_permalink(81) ?>" class="section-more__link">
                            <span>Задать свой вопрос... </span>
                            <img src="<?php echo get_bloginfo('template_url') ?>/dist/img/icon-question.png" alt="">
                        </a>
                    </div>
                </div>
            </section>

            <?php get_template_part('partials/footer'); ?>
        </div>
    </body>
</html>
