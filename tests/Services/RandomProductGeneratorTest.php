<?php

declare(strict_types=1);

namespace App\Tests\Services;

use App\Model\Product;
use App\Services\RandomProductGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RandomProductGeneratorTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testGenerateProductsData()
    {
        /** @var RandomProductGenerator $randomProductGenerator */
        $randomProductGenerator = $this->getContainer()->get(RandomProductGenerator::class);
        $actual = $randomProductGenerator->generateProductsData(150);

        foreach ($actual as $key => $item) {
            $this->assertInstanceOf(Product::class, $item);
            $this->assertEquals($key, $item->getId());

            self::assertNotEmpty($item->getProducts());
        }
    }
}
