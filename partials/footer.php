<footer class="footer js-footer">
    <div class="footer-first">
        <div class="uk-container uk-container-large">
            <div class="uk-grid" uk-grid>
                <div class="uk-width-1-2 uk-width-1-4@s footer__cell footer__cell_first">
                    <div class="footer__head">Адреса:</div>
                    <?php foreach (get_field('address', 'option') as $address): ?>
                    <a href="<?php echo $address['link'] ?>" class="footer__address">
                        <?php echo $address['text'] ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <div class="uk-width-1-2 uk-width-1-4@s footer__cell footer__cell_second">
                    <div class="footer__head">Как купить:</div>
                    <?php wp_nav_menu([
                        'theme_location' => 'how_to_buy',
                        'container' => false,
                        'menu_class' => 'footer__menu'
                    ]) ?>
                </div>
                <div class="uk-width-1-2 uk-width-1-4@s footer__cell footer__cell_third">
                    <div class="footer__head">Разделы:</div>
                    <?php wp_nav_menu([
                        'theme_location' => 'sections',
                        'container' => false,
                        'menu_class' => 'footer__menu'
                    ]) ?>
                </div>
                <div class="uk-width-1-2 uk-width-1-4@s footer__cell footer__cell_fourth">
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

<div id="question" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <?php echo do_shortcode('[contact-form-7 id="9" title="Задать вопрос"]') ?>
    </div>
</div>

<div id="individual" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <?php echo do_shortcode('[contact-form-7 id="901" title="Индивидуальный проект мебели"]') ?>
    </div>
</div>

<!-- <button class="totop js-totop" uk-totop uk-scroll></button> -->

<script type="text/javascript" src="<?php echo get_bloginfo('template_url') ?>/dist/main.js"></script>

<?php wp_footer() ?>