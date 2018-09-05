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

            <?php get_template_part('partials/footer'); ?>
        </div>
    </body>
</html>