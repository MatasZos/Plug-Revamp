<?php
class Product {
public $id, $name, $price, $description, $image_url, $category;

public function __construct($id, $name, $price, $description, $image_url, $category) {
$this->id = $id;
$this->name = $name;
$this->price = $price;
$this->description = $description;
$this->image_url = $image_url;
$this->category = $category;
}
}