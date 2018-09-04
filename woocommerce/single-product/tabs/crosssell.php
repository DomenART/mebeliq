<?php
$crosssell_ids = get_post_meta(get_the_ID(), '_crosssell_ids', true);
$limit = 10;
$products = count($crosssell_ids) > 0 ? new WP_Query(array(
    'post_type' => 'product',
    'ignore_sticky_posts' => 1,
    'no_found_rows' => 1,
    'posts_per_page' => $limit,
    //'orderby' => $orderby,
    'post__in' => $crosssell_ids
)) : null;

global $woocommerce_loop;
$woocommerce_loop['columns'] = 5;
?>

<?php if ($products && $products->have_posts()) : ?>
    <div class="product-crosssell">
        <div class="product-crosssell__title">В комплекте:</div>
        <div class="product-crosssell__products">
            <div class="products uk-grid uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-5@xl js-crosssell-list" uk-grid>
                <?php while ($products->have_posts()) : $products->the_post(); ?>
                    <?php wc_get_template_part('content', 'product'); ?>
                <?php endwhile; wp_reset_query(); ?>
            </div>
        </div>
        <?php if (count($crosssell_ids) > $limit) : ?>
        <button class="product-crosssell__all js-crosssell-load-all" data-product="<?php the_ID() ?>">Показать все доступные модули</button>
        <?php endif; ?>
    </div>
<?php endif; ?>