<?php
/*
Template Name: Контакты
*/
?>
<!DOCTYPE html>
<html>
    <head>
        <?php get_template_part( 'partials/head' ) ?>
    </head>
    <body>
        <div class="wrapper">
            <div class="page js-page">
                <div class="header-wrap">
                    <?php get_template_part('partials/header'); ?>
                </div>

                <div class="uk-container">
                    <?php // bcn_display() ?>
                    <?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>
                        <h1><?php the_title(); ?></h1>
                        <div class="page-content">
                            <?php the_content(); ?>
                        </div>
                    <?php endwhile; else: ?>
                        <div class="page-content">
                            <p>Извините, ничего не найдено.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="contacts">
                    <div class="uk-grid uk-grid-collapse">
                        <div class="contacts__map-first uk-width-1-2@s">
                            <?php the_field('map_first', 'option') ?>
                        </div>
                        <div class="contacts__info uk-width-1-2@s">
                            <div class="contacts__title">Контакты</div>

                            <div class="contacts__list">
                                <?php if ($contacts = get_field('contacts', 'option')) : ?>
                                    <?php foreach ($contacts as $row): ?>
                                        <div class="contacts__item"><?php echo $row['text'] ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="contacts__item">
                                    <a href="mailto:<?php the_field('email', 'option') ?>"><?php the_field('email', 'option') ?></a>
                                </div>
                            </div>

                            <div class="contacts__map-second">
                                <?php the_field('map_second', 'option') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php get_template_part( 'partials/footer' ) ?>
        </div>
    </body>
</html>