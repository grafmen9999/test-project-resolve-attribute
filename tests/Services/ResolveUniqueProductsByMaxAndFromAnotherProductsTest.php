<?php

declare(strict_types=1);

namespace App\Tests\Services;

use App\Factory\ProductFactory;
use App\Model\Product;
use App\Services\RandomProductGenerator;
use App\Services\ResolveUniqueProductsByMaxAndFromAnotherProducts;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResolveUniqueProductsByMaxAndFromAnotherProductsTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::bootKernel();
    }

    /**
     * @dataProvider provideProducts
     *
     * @param array $products
     * @param array $expected
     */
    public function testResolve(array $products, array $expected): void
    {
        $service = $this->getContainer()->get(ResolveUniqueProductsByMaxAndFromAnotherProducts::class);

        $uniqueProducts = $service->resolve($products);

        $this->assertEqualsCanonicalizing(array_map(fn (Product $product) => $product->getId(), $uniqueProducts), $expected);
    }


    public function provideProducts(): iterable
    {
        $generator = $this->getContainer()->get(RandomProductGenerator::class);

        $products = $generator->generateProductsData(linkToInner: false);

        $products[0]->addProduct($products[2]);
        $products[0]->addProduct($products[4]);
        $products[1]->addProduct($products[5]);
        $products[2]->addProduct($products[1]);
        $products[2]->addProduct($products[4]);
        $products[5]->addProduct($products[8]);
        $products[6]->addProduct($products[9]);
        $products[7]->addProduct($products[0]);
        $products[7]->addProduct($products[5]);
        $products[8]->addProduct($products[5]);
        $products[9]->addProduct($products[1]);
        $products[9]->addProduct($products[4]);

        return [
            [
                $products,
                [
                    2, 4, 5, 1, 8, 9, 0,
                ]
            ]
        ];
    }
}
