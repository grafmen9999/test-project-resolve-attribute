<?php

declare(strict_types=1);

namespace App\Services;

use App\Factory\ProductFactory;
use Symfony\Bundle\MakerBundle\Str;

class RandomProductGenerator
{
    public function __construct(
        private ProductFactory $factory,
    ) {
    }

    public function generateProductsData(int $count = 10, bool $linkToInner = true): array
    {
        $products = [];

        for ($i = 0; $i < $count; $i++) {
            array_push($products, $this->factory->createWithIdAndName($i, Str::getRandomTerm()));
        }

        if (!$linkToInner) {
            return $products;
        }

        for ($i = 0; $i < $count * 100; $i++) {
            $rand = abs(random_int(PHP_INT_MIN, PHP_INT_MAX) % $count);
            $product = $products[($i % $count)];
            $product->addProduct($products[$rand]);
        }

        return $products;
    }
}