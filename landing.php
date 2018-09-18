<?php
/*
Template Name: Главная
*/
?>
<!DOCTYPE html>
<html>
    <head>
        <?php get_template_part( 'partials/head' ) ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="js-page">
                <?php get_template_part( 'partials/header' ) ?>

                <?php if (is_active_sidebar('home-sidebar')) : ?>
                    <section>
                        <div class="uk-container uk-container-large">
                            <?php dynamic_sidebar('home-sidebar') ?>
                        </div>
                    </section>
                <?php endif; ?>

                <section class="section-popular">
                    <div class="uk-container">
                        <div class="section-popular__title">Популярные Товары</div>

                        <?php echo do_shortcode('[products limit="12" columns="4" visibility="featured"]'); ?>

                        <div class="section-more">
                            <a href="<?php the_permalink(get_option('woocommerce_shop_page_id')) ?>" class="section-more__link">
                                <span>Перейти к каталогу...</span>
                                <infosrc="<?php echo get_bloginfo('template_url') ?>/dist/img/icon-catalog.png" alt="">
                            </a>
                        </div>
                    </div>
                </section>

                <div class="uk-visible@s">
                    <?php if ($project = get_field('project')) : ?>
                    <section class="section-individual">
                        <div class="uk-container">
                            <div class="section-individual__title"><?php echo $project['title'] ?></div>

                            <div class="uk-grid">
                                <div class="uk-width-3-5">
                                    <div class="section-individual__image">
                                        <img
                                            src="<?php echo $project['image']['url'] ?>"
                                            alt="<?php echo $project['image']['title'] ?>"
                                        >
                                    </div>
                                </div>
                                <div class="uk-width-2-5 uk-flex uk-flex-middle">
                                    <div class="section-individual__text">
                                        <?php echo $project['text'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="uk-container">
                        <div class="section-more">
                            <a href="#individual" class="section-more__link">
                                <span>Связаться для заказа...</span>
                                <img src="<?php echo get_bloginfo('template_url') ?>/dist/img/icon-envelope.png" alt="">
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>
                    <section class="section-content">
                        <div class="uk-container">
                            <div class="section-content__title">
                                <span><?php the_title() ?></span>
                            </div>
                            <div class="section-content__text"><?php the_content() ?></div>
                            <div class="section-more">
                                <a href="#question" class="section-more__link">
                                    <span>Задать свой вопрос... </span>
                                    <img src="<?php echo get_bloginfo('template_url') ?>/dist/img/icon-question.png" alt="">
                                </a>
                            </div>
                        </div>
                    </section>
                    <?php endwhile; endif; ?>
                </div>
            </div>

            <?php get_template_part( 'partials/footer' ) ?>
        </div>
    </body>
</html>