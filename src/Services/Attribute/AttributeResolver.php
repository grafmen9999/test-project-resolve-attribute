<?php

declare(strict_types=1);

namespace App\Services\Attribute;

class AttributeResolver
{
    public function resolveAttributesByDictionary(array $dictionary, string $slug, string $separator = '-'): array
    {
        $result = [];

        $lastKey = null;
        $currentSlugArray = [];

        foreach (explode($separator, $slug) as $itemSlug) {
            $currentSlugArray[] = $itemSlug;
            $currentSlug = implode($separator, $currentSlugArray);

            $key = array_search($currentSlug, $dictionary);

            if (false !== $key) {
                $lastKey = $key;
                continue;
            }

            if (null !== $lastKey) {
                $result[] = $dictionary[$lastKey];
                $currentSlugArray = [$itemSlug];
                $lastKey = null;
            }
        }

        if (null !== $lastKey) {
            $result[] = $dictionary[$lastKey];
        }

        return $result;
    }
}