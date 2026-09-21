<?php
require_once 'Product.php';

class ProductVariant extends Product {
    public $color, $size, $quantity;

    public function __construct(Product $product, $color, $size, $quantity) {
        parent::__construct(
            $product->id,
            $product->name,
            $product->price,
            $product->description,
            $product->image_url,
            $product->category
        );
        $this->color = $color;
        $this->size = $size;
        $this->quantity = $quantity;
    }
}
