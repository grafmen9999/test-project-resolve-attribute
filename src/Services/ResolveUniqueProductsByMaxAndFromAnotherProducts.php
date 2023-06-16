<?php

declare(strict_types=1);

namespace App\Services;

use App\Factory\ProductFactory;
use App\Model\Product;

class ResolveUniqueProductsByMaxAndFromAnotherProducts
{
    /**
     * @param array<array-key, Product> $products
     * @param int $quantity
     *
     * @return array<array-key, Product>
     */
    public function resolve(array $products, int $quantity = 10): array
    {
        $resultProducts = [];
        $productsInProducts = [];

        while (count($resultProducts) < $quantity && !empty($products)) {
            $product = current($products);

            if (!$product->hasProducts()) {
                unset($products[key($products)]);
                continue;
            }

            if (!isset($productsInProducts[$product->getId()])) {
                $productsInProducts[$product->getId()] = $product->getProducts();
            }

            if (empty($productsInProducts[$product->getId()])) {
                unset($products[key($products)]);
                reset($products);
                continue;
            }

            $candidateProduct = current($productsInProducts[$product->getId()]);

            if ($this->alreadyExistsInArray($resultProducts, $candidateProduct)) {
                unset($productsInProducts[$product->getId()][key($productsInProducts[$product->getId()])]);
                reset($productsInProducts[$product->getId()]);
                continue;
            }

            array_push($resultProducts, $candidateProduct);
            unset($productsInProducts[$product->getId()][key($productsInProducts[$product->getId()])]);

            if (false === next($productsInProducts[$product->getId()])) {
                reset($productsInProducts[$product->getId()]);
            }

            if (false === next($products)) {
                reset($products);
            }
        }

        return $resultProducts;
    }

    /**
     * @param array<array-key, Product> $products
     * @param Product $product
     *
     * @return bool
     */
    protected function alreadyExistsInArray(array $products, Product $product): bool
    {
        foreach ($products as $p) {
            if ($p->getId() === $product->getId()) {
                return true;
            }
        }

        return false;
    }
}