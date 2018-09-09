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
                                <h1 class="library__title"><?php the_title(); ?></h1>

                                <?php if ($date = get_the_date()) : ?>
                                    <div class="library__date">
                                        Опубликовано: <span><?php echo $date ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>
                                <?php the_content(); ?>
                            <?php endwhile; else: ?>
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