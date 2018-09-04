<?php
global $product;

$columns = apply_filters('woocommerce_product_thumbnails_columns', 6);
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

if (has_post_thumbnail()) {
    array_unshift($attachment_ids, $post_thumbnail_id);
}

if (!has_post_thumbnail() && $attachment_ids) {
    $post_thumbnail_id = current($attachment_ids);
}
?>
<div class="product-gallery js-gallery">
    <?php if ($post_thumbnail_id): ?>
        <img
            src="<?php echo wp_get_attachment_image_url($post_thumbnail_id, 'large') ?>"
            data-full="<?php echo wp_get_attachment_image_url($post_thumbnail_id, 'full') ?>"
            alt="<?php echo wp_get_attachment_caption($post_thumbnail_id) ?>"
            class="product-gallery__main js-gallery-main"
        >
    <?php endif; ?>

    <?php if ($attachment_ids): ?>
    <div class="product-gallery__thumbnails js-gallery-thumbnails">
        <ul class="uk-slider-items uk-grid uk-grid-small uk-child-width-1-<?php echo $columns ?>">
            <?php foreach ($attachment_ids as $attachment_id): ?>
            <li>
                <img
                    src="<?php echo wp_get_attachment_image_url($attachment_id, 'thumbnail') ?>"
                    alt="<?php echo wp_get_attachment_caption($attachment_id) ?>"
                    data-large="<?php echo wp_get_attachment_image_url($attachment_id, 'large') ?>"
                    data-full="<?php echo wp_get_attachment_image_url($attachment_id, 'full') ?>"
                    class="product-gallery__thumbnail"
                >
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>