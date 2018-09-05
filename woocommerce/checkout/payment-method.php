<?php
defined('ABSPATH') || exit;
?>
<li class="wc_payment_method payment_method_<?php echo $gateway->id; ?>">
    <label class="input-radio"><input id="payment_method_<?php echo $gateway->id; ?>" type="radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" /><span></span></label>

    <label for="payment_method_<?php echo $gateway->id; ?>">
        <?php echo $gateway->get_title(); ?>
    </label>

    <?php if ($icon = $gateway->get_icon()) : ?>
        <div class="wc_payment_method__icon">
            <?php echo $icon; ?>
        </div>
    <?php endif; ?>

    <?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
        <div class="wc_payment_method__desc payment_method_<?php echo $gateway->id; ?>" <?php if ( ! $gateway->chosen ) : ?>style="display:none;"<?php endif; ?>>
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>
