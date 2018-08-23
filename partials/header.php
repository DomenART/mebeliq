<?php

function modify_data($array) {
    $thumbnail_id = get_woocommerce_term_meta($array->term_id, 'thumbnail_id', true);
    $output = (array) $array;
    $output['image'] = wp_get_attachment_image_url($thumbnail_id, 'full');
    $output['link'] = get_category_link($output['term_id']);
    $output['children'] = array_map('modify_data', get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'child_of' => $output['term_id']
    ]));
    return $output;
}

$categories = array_map('modify_data', get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'exclude' => '15',
    'parent' => 0,
]));

?>
<header class="header">
    <div class="uk-container uk-container-large">
        <div class="header__container">
            <div class="header-logo">
                <a href="/" class="header-logo__image">
                    <img src="<?php bloginfo('template_url') ?>/dist/img/logo.png" alt="">
                </a>
                <div class="header-logo__slogan">
                    <?php bloginfo('description') ?>
                </div>
            </div>

            <?php wp_nav_menu([
                'theme_location' => 'mainmenu',
                'container' => false,
                'menu_class' => 'mainmenu'
            ]) ?>

            <div class="header-cart">
                <div class="header-cart__icon"></div>
                <div class="header-cart__info">
                    <div class="header-cart__count">
                        2 товара<br>
                    </div>
                    <div class="header-cart__price">
                        17 060.-
                    </div>
                </div>
            </div>

            <div class="header__address">
                г.Брянск
            </div>

            <?php get_search_form() ?>
        </div>

        <div class="catalog-toggle" uk-toggle="target: .catalog-menu; cls: catalog-menu_open">
            <span>
                <i></i>
                <i></i>
                <i></i>
            </span>
            Выбрать мебель
        </div>

        <ul class="catalog-menu">
            <?php foreach ($categories as $category): ?>
            <li <?php if ($_SERVER['REQUEST_URI'] == $category['link']): ?>class="uk-active"<?php endif; ?>>
                <a href="<?php echo $category['link'] ?>" class="catalog-menu-item">
                    <span class="catalog-menu-item__wrap">
                        <span class="catalog-menu-item__image">
                            <img src="<?php echo $category['image'] ?>" alt="">
                        </span>
                        <span class="catalog-menu-item__name"><?php echo $category['name'] ?></span>
                    </span>
                </a>
                <?php if ($children = $category['children']): ?>
                    <div class="catalog-menu__dropdown">
                        <ul>
                            <?php foreach ($children as $child): ?>
                            <li>
                                <a href="<?php echo $child['link'] ?>"><?php echo $child['name'] ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>

        <div>
            <?php foreach ($categories as $category): ?>
                <?php echo $category->name ?>
                <?php if ($thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true)): ?>
                    <?php wp_get_attachment_image($thumbnail_id) ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</header>