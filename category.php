<!DOCTYPE html>
<html>
<head>
    <?php get_template_part('partials/head'); ?>
</head>
<body>
<div class="wrapper">
    <div class="js-page">
        <div class="header-wrap">
            <?php get_template_part('partials/header'); ?>
        </div>

        <div class="library">
            <div class="uk-container uk-container-large">
                <div class="uk-grid uk-grid-large" uk-grid>
                    <div class="uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l library__sidebar">
                        <?php get_template_part('partials/library-sidebar'); ?>
                    </div>

                    <div class="uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l">
                        <div class="library__content">
                            <div class="library__breadcrumb">
                                <?php woocommerce_breadcrumb() ?>
                            </div>

                            <div class="library__headline">
                                <h1 class="library__title"><?php single_cat_title(); ?></h1>
                            </div>

                            <?php if (have_posts()) : ?>
                                <div class="uk-child-width-1-2@m" uk-grid>
                                    <?php while (have_posts()) : the_post(); ?>
                                        <div>
                                            <div class="uk-card uk-card-default">
                                                <?php if ($image = get_the_post_thumbnail_url()) : ?>
                                                <a href="<?php echo get_post_permalink() ?>" class="uk-height-medium uk-display-block uk-card-media-top uk-cover-container">
                                                    <img src="<?php echo $image ?>" alt="" uk-cover>
                                                </a>
                                                <?php endif; ?>
                                                <div class="uk-card-body">
                                                    <a href="<?php echo get_post_permalink() ?>" >
                                                        <h3 class="uk-card-title"><?php the_title(); ?></h3>
                                                    </a>
                                                    <?php the_excerpt(); ?>
                                                    <a href="<?php echo get_post_permalink() ?>" class="uk-button uk-button-default">
                                                        Подробнее
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                                <?php the_posts_pagination() ?>
                            <?php else: ?>
                                <p>Извините, ничего не найдено.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_template_part('partials/footer'); ?>
</div>
</body>
</html>