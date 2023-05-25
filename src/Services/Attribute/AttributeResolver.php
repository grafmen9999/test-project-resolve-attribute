<?php

declare(strict_types=1);

namespace App\Services\Attribute;

class AttributeResolver
{
    public function resolveAttributesByDictionary(array $dictionary, string $slug): array
    {
        // some action for resolve attributes;
        $result = [
            'iphone-14-pro',
            'iphone-13-pro',
            'iphone-14-pro-max',
        ];

        return $result;
    }
}