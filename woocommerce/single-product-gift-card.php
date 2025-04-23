<?php
defined('ABSPATH') || exit;

global $product;
if (!$product)
    return;
?>

<div class="gift-card-container">
    <div class="gift-card-grid">
        <div class="gift-card-image">
            <?php echo $product->get_image('full'); ?>
        </div>

        <div class="gift-card-info">
            <h1 class="gift-card-title"><?php the_title(); ?></h1>

            <div class="gift-card-full-description">
                <?php the_content(); ?>
            </div>

            <div class="gift-card-short-description">
                <?php echo apply_filters('woocommerce_short_description', $post->post_excerpt); ?>
            </div>

            <form class="gift-card-form cart" method="post" enctype="multipart/form-data"
                action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>">
                <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($product->get_id()); ?>">
                <input type="hidden" name="quantity" value="1">

                <div class="form-group">
                    <label for="gift_card_amount">Montant à offrir (€)</label>
                    <input type="number" id="gift_card_amount" name="gift_card_amount" min="5" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="gift_card_sender">Votre nom</label>
                    <input type="text" id="gift_card_sender" name="gift_card_sender" required>
                </div>

                <div class="form-group">
                    <label for="gift_card_recipient">Nom du destinataire</label>
                    <input type="text" id="gift_card_recipient" name="gift_card_recipient" required>
                </div>

                <div class="form-group">
                    <label for="gift_card_email">Email du destinataire</label>
                    <input type="email" id="gift_card_email" name="gift_card_email" required>
                </div>

                <div class="form-group">
                    <label for="gift_card_message">Message personnalisé (optionnel)</label>
                    <textarea id="gift_card_message" name="gift_card_message" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="gift-card-button single_add_to_cart_button button alt">
                        Ajouter au panier
                    </button>
                </div>

                <?php do_action('woocommerce_after_add_to_cart_button'); ?>
            </form>
        </div>
    </div>
</div>