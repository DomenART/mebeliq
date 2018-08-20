<!DOCTYPE html>
<html>
    <head>
        <?php get_template_part('partials/head'); ?>
    </head>
    <body>
        <div class="wrapper uk-offcanvas-content">
            <?php get_template_part('partials/header'); ?>

            <div class="page-internal">
                <div class="uk-container">
                    <h1><?php single_cat_title() ?></h1>
                    <?php if (have_posts()) : ?>
                        <div class="uk-child-width-1-2@m" uk-grid>
                            <?php  $idx = 0; while ( have_posts() ) : $idx++; the_post(); ?>
                                <div>
                                    <div class="uk-card uk-card-default">
                                        <?php if (has_post_thumbnail() && $idx%2 != 0) : ?>
                                            <a href="<?php echo get_post_permalink() ?>" class="uk-card-media-top">
                                                <?php the_post_thumbnail() ?>
                                            </a>
                                        <?php endif; ?>
                                        <div class="uk-card-body">
                                            <h3 class="uk-card-title"><?php the_title(); ?></h3>
                                            <?php the_excerpt(); ?>
                                            <a href="<?php echo get_post_permalink() ?>" class="uk-button uk-button-default">
                                                <?php pll_e('more'); ?>
                                            </a>
                                        </div>
                                        <?php if (has_post_thumbnail() && $idx%2 == 0) : ?>
                                            <a href="<?php echo get_post_permalink() ?>" class="uk-card-media-bottom">
                                                <?php the_post_thumbnail() ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php the_posts_pagination() ?>
                    <?php else: ?>
                        <div class="page-content">
                            <p>Извините, ничего не найдено.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php get_template_part('partials/footer'); ?>
        </div>
    </body>
</html>