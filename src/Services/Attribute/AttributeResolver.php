<?php

declare(strict_types=1);

namespace App\Services\Attribute;

class AttributeResolver
{
    public function resolveAttributesByDictionary(array $dictionary, string $slug): array
    {
        // some action for resolve attributes;
        $result = [];

        $explodedSlug = explode('-', $slug);

        $lastKey = null;
        $currentSlugArray = [];

        foreach ($explodedSlug as $itemSlug) {

            $currentSlugArray[] = $itemSlug;
            $currentSlug = implode('-', $currentSlugArray);

            $key = array_search($currentSlug, $dictionary);

            if (false === $key) {
                if (null === $lastKey) {
                    continue;
                }

                $result[] = $dictionary[$lastKey];
                $currentSlugArray = [$itemSlug];
                $lastKey = null;
                continue;
            }

            $lastKey = $key;
        }

        if (null !== $lastKey) {
            $result[] = $dictionary[$lastKey];
        }

        return $result;
    }
}