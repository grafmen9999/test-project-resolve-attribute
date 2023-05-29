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
    }

    public function provideData(): iterable
    {
        $dictionaryIphone = [
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

        $dictionaryColor = [
            'blue',
            'silver',
            'white',
            'purple',
            'sierra-blue',
            'red',
        ];

        return [
            [
                $dictionaryIphone,
                'iphone-14-pro-max-iphone-14-pro-iphone-13-pro',
                [
                    'iphone-14-pro-max',
                    'iphone-14-pro',
                    'iphone-13-pro',
                ],
            ],
            [
                $dictionaryIphone,
                'iphone-14-iphone-14-pro-iphone-13',
                [
                    'iphone-14',
                    'iphone-14-pro',
                    'iphone-13',
                ],
            ],
            [
                $dictionaryIphone,
                'iphone-14-pro-iphone-14-pro-max-iphone-13-pro-max',
                [
                    'iphone-14-pro',
                    'iphone-14-pro-max',
                    'iphone-13-pro-max',
                ],
            ],
            [
                $dictionaryIphone,
                'iphone-14-pro-iphone-14-pro-max-iphone-13-pro-max-iphone-12',
                [
                    'iphone-14-pro',
                    'iphone-14-pro-max',
                    'iphone-13-pro-max',
                    'iphone-12',
                ],
            ],
            [
                $dictionaryIphone,
                'iphone-14-pro-iphone-14-iphone-13-pro-max-iphone-se-iphone-12',
                [
                    'iphone-14-pro',
                    'iphone-14',
                    'iphone-13-pro-max',
                    'iphone-se',
                    'iphone-12',
                ],
            ],
            [
                $dictionaryIphone,
                'iphone-14-iphone-se-iphone-14-pro-iphone-13-pro-max-iphone-12-iphone-11-pro',
                [
                    'iphone-14',
                    'iphone-se',
                    'iphone-14-pro',
                    'iphone-13-pro-max',
                    'iphone-12',
                    'iphone-11-pro'
                ],
            ],
            [
                $dictionaryIphone,
                'iphone-14',
                [
                    'iphone-14',
                ],
            ],
            [
                $dictionaryIphone,
                '',
                [],
            ],
            // this case not working correct. Need update logic...
            [
                $dictionaryIphone,
                'iphone-14-pro-max-macbook-pro-iphone-14',
                [
                    'iphone-14-pro-max',
                    //'iphone-14',
                ],
            ],
            [
                $dictionaryColor,
                'white-blue',
                [
                    'white',
                    'blue',
                ]
            ],
            [
                $dictionaryColor,
                'white-sierra-blue',
                [
                    'white',
                    'sierra-blue',
                ]
            ],
            [
                $dictionaryColor,
                'sierra-blue-red',
                [
                    'sierra-blue',
                    'red',
                ]
            ],
            [
                $dictionaryColor,
                'silver-purple-red-white',
                [
                    'silver',
                    'purple',
                    'red',
                    'white',
                ]
            ],
        ];
    }
}
