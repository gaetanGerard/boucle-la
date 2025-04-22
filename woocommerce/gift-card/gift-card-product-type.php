<?php
// Gift Card Product Type logic here

if (!class_exists('WC_Product_Gift_Card')) {
    class WC_Product_Gift_Card extends WC_Product
    {
        public function __construct($product)
        {
            $this->product_type = 'gift_card';
            parent::__construct($product);
        }

        public function is_purchasable()
        {
            return true;
        }
    }
}

// Register the new product type
add_filter('product_type_selector', function ($types) {
    $types['gift_card'] = __('Carte Cadeau', 'bo-theme');
    return $types;
});

// Make WooCommerce recognize the new product type
add_filter('woocommerce_product_class', function ($classname, $product_type) {
    if ($product_type === 'gift_card') {
        return 'WC_Product_Gift_Card';
    }
    return $classname;
}, 10, 2);
