<footer class="footer">
    <div class="footer-first">
        <div class="uk-container uk-container-large">
            <div class="uk-grid" uk-grid>
                <div class="uk-width-1-4">
                    <div class="footer__head">Адреса:</div>
                    <?php foreach (get_field('address', 'option') as $address): ?>
                    <a href="<?php echo $address['link'] ?>" class="footer__address">
                        <?php echo $address['text'] ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <div class="uk-width-1-4">
                    <div class="footer__head">Как купить:</div>
                    <?php wp_nav_menu([
                        'theme_location' => 'how_to_buy',
                        'container' => false,
                        'menu_class' => 'footer__menu'
                    ]) ?>
                </div>
                <div class="uk-width-1-4 uk-text-right">
                    <div class="footer__head">Разделы:</div>
                    <?php wp_nav_menu([
                        'theme_location' => 'sections',
                        'container' => false,
                        'menu_class' => 'footer__menu'
                    ]) ?>
                </div>
                <div class="uk-width-1-4 uk-text-right">
                    <div class="footer__head">Информация:</div>
                    <?php wp_nav_menu([
                        'theme_location' => 'information',
                        'container' => false,
                        'menu_class' => 'footer__menu'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-second">
        <div class="uk-container uk-container-large">
            <div class="footer__copyright">
                <?php the_field('copyright', 'option') ?>
            </div>
        </div>
    </div>
</footer>

<!-- <button class="totop js-totop" uk-totop uk-scroll></button> -->

<script type="text/javascript" src="<?php echo get_bloginfo('template_url') ?>/dist/main.js"></script>

<?php wp_footer() ?>