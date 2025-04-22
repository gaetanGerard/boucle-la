<?php
add_action('woocommerce_product_options_general_product_data', function () {
    global $post;
    echo '<div class="options_group show_if_gift_card">';
    woocommerce_wp_text_input(array(
        'id' => '_gift_card_validity_months',
        'label' => __('Validité de la carte cadeau (mois)', 'bo-theme'),
        'desc_tip' => 'true',
        'description' => __('Nombre de mois de validité après achat. Par défaut : 12', 'bo-theme'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => '1',
            'min' => '1'
        ),
        'value' => get_post_meta($post->ID, '_gift_card_validity_months', true) ?: 12
    ));
    echo '</div>';
});

add_action('woocommerce_process_product_meta', function ($post_id) {
    $validity = isset($_POST['_gift_card_validity_months']) ? intval($_POST['_gift_card_validity_months']) : 12;
    update_post_meta($post_id, '_gift_card_validity_months', $validity);
});
add_action('admin_footer', function () {
    if ('product' != get_post_type())
        return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            if ($('select#product_type').val() === 'gift_card') {
                $('.show_if_gift_card').show();
            }
            $('select#product_type').on('change', function () {
                if ($(this).val() === 'gift_card') {
                    $('.show_if_gift_card').show();
                } else {
                    $('.show_if_gift_card').hide();
                }
            });
        });
    </script>
    <?php
});
