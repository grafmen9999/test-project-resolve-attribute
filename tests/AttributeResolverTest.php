<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Do not modify!
 */
class AttributeResolverTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @param array $dictionary
     * @param string $slug
     * @param array $expectedResult
     *
     * @dataProvider provideData
     */
    public function testGetDataAttributesFromStringAndDictionary(
        array $dictionary,
        string $slug,
        array $expectedResult,
    ): void {
        $attributeResolver = $this->getContainer()->get('App\Services\Attribute\AttributeResolver');
        $actual = $attributeResolver->resolveAttributesByDictionary($dictionary, $slug);

        $this->assertEqualsCanonicalizing($expectedResult, $actual);
        //
        //sort($actual);
        //sort($expectedResult);
        //
        //$this->assertEquals(implode(',', $expectedResult), implode(',', $actual));
    }

    public function provideData(): iterable
    {
        $dictionary = [
            'iphone-11',
            'iphone-12',
            'iphone-13',
            'iphone-14',
            'iphone-11-pro',
            'iphone-12-pro',
            'iphone-13-pro',
            'iphone-14-pro',
            'iphone-11-pro-max',
            'iphone-12-pro-max',
            'iphone-13-pro-max',
            'iphone-14-pro-max',
            'iphone-se',
        ];

        return [
            'Test #1' => [
                $dictionary,
                'iphone-14-pro-max-iphone-14-pro-iphone-13-pro',
                [
                    'iphone-14-pro-max',
                    'iphone-14-pro',
                    'iphone-13-pro',
                ],
            ],
            'Test #2' => [
                $dictionary,
                'iphone-14-iphone-14-pro-iphone-13',
                [
                    'iphone-14',
                    'iphone-14-pro',
                    'iphone-13',
                ],
            ],
            'Test #3' => [
                $dictionary,
                'iphone-14-pro-iphone-14-pro-max-iphone-13-pro-max',
                [
                    'iphone-14-pro',
                    'iphone-14-pro-max',
                    'iphone-13-pro-max',
                ],
            ],
            'Test #4' => [
                $dictionary,
                'iphone-14-pro-iphone-14-pro-max-iphone-13-pro-max-iphone-12',
                [
                    'iphone-14-pro',
                    'iphone-14-pro-max',
                    'iphone-13-pro-max',
                    'iphone-12',
                ],
            ],
        ];
    }
}
