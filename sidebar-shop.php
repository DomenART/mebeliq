<?php if (is_active_sidebar('shop-filters')): ?>
    <ul class="shop-filters" uk-accordion="multiple: true">
        <?php dynamic_sidebar('shop-filters'); ?>
    </ul>
<?php endif; ?>