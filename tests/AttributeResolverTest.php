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
     * @dataProvider provideIPhoneData
     * @dataProvider provideColorData
     * @dataProvider provideMacData
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

    public function provideIPhoneData(): iterable
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
            [
                $dictionary,
                'iphone-14-pro-max-iphone-14-pro-iphone-13-pro',
                [
                    'iphone-14-pro-max',
                    'iphone-14-pro',
                    'iphone-13-pro',
                ],
            ],
            [
                $dictionary,
                'iphone-14-iphone-14-pro-iphone-13',
                [
                    'iphone-14',
                    'iphone-14-pro',
                    'iphone-13',
                ],
            ],
            [
                $dictionary,
                'iphone-14-pro-iphone-14-pro-max-iphone-13-pro-max',
                [
                    'iphone-14-pro',
                    'iphone-14-pro-max',
                    'iphone-13-pro-max',
                ],
            ],
            [
                $dictionary,
                'iphone-14-pro-iphone-14-pro-max-iphone-13-pro-max-iphone-12',
                [
                    'iphone-14-pro',
                    'iphone-14-pro-max',
                    'iphone-13-pro-max',
                    'iphone-12',
                ],
            ],
            [
                $dictionary,
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
                $dictionary,
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
                $dictionary,
                'iphone-14',
                [
                    'iphone-14',
                ],
            ],
            [
                $dictionary,
                '',
                [],
            ],
            // this case not working correct. Need update logic...
            [
                $dictionary,
                'iphone-14-pro-max-macbook-pro-iphone-14',
                [
                    'iphone-14-pro-max',
                    'iphone-14',
                ],
            ],
        ];
    }

    public function provideColorData(): iterable
    {
        $dictionary = [
            'blue',
            'silver',
            'white',
            'purple',
            'sierra-blue',
            'red',
        ];

        return [
            [
                $dictionary,
                'white-blue',
                [
                    'white',
                    'blue',
                ]
            ],
            [
                $dictionary,
                'white-sierra-blue',
                [
                    'white',
                    'sierra-blue',
                ]
            ],
            [
                $dictionary,
                'sierra-blue-red',
                [
                    'sierra-blue',
                    'red',
                ]
            ],
            [
                $dictionary,
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

    public function provideMacData(): iterable
    {
        $dictionary = [
            'macbook-pro',
            'imac',
            'mac-mini',
            'macbook-air-m1',
            'macbook-air-m2',
            'macbook-pro-13-m1',
            'macbook-pro-14-m1',
            'macbook-pro-14-m2',
            'macbook-pro-16-m1',
            'macbook-pro-16-m2',
        ];

        return [
            [
                $dictionary,
                'macbook-pro-16-m1',
                [
                    'macbook-pro-16-m1',
                ],
            ],
            [
                $dictionary,
                'macbook-pro-16-m1-macbook-pro-13-m1',
                [
                    'macbook-pro-16-m1',
                    'macbook-pro-13-m1',
                ],
            ],
            [
                $dictionary,
                'macbook-air-m1-mac-mini-macbook-pro',
                [
                    'macbook-air-m1',
                    'mac-mini',
                    'macbook-pro',
                ],
            ],
        ];
    }
}
