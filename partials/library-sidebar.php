<div class="library-sidebar">
    <div class="library-sidebar__title">Список статей:</div>
    <?php wp_nav_menu([
        'theme_location' => 'library',
        'container' => false,
        'menu_class' => 'library-sidebar__menu'
    ]) ?>
</div>