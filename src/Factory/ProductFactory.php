<?php

declare(strict_types=1);

namespace App\Factory;

use App\Model\Product;

class ProductFactory extends Factory
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }

    public function createWithIdAndName(int $id, string $name): Product
    {
        /** @var Product $product */
        $product = $this->create();

        $product->setId($id);
        $product->setName($name);

        return $product;
    }
}