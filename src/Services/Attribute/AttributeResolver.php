<?php

declare(strict_types=1);

namespace App\Services\Attribute;

class AttributeResolver
{
    private const DEFAULT_SEPARATOR = '-';

    public function resolveAttributesByDictionary(array $dictionary, string $slug, string $explodeSeparator = self::DEFAULT_SEPARATOR, string $implodeSeparator = self::DEFAULT_SEPARATOR): array
    {
        $explodedSlug = explode($explodeSeparator, $slug);

        $result = [];
        $lastSuccessKey = null;
        $keysForRemove = [];
        $currentSlugArray = [];
        $currentKeysForRemove = [];

        while (!empty($explodedSlug)) {
            $currentValue = current($explodedSlug);
            $currentKey = key($explodedSlug);

            array_push($currentSlugArray, $currentValue);
            array_push($currentKeysForRemove, $currentKey);

            $currentSlug = implode($explodeSeparator, $currentSlugArray);

            $searchKeyFromDictionary = array_search($currentSlug, $dictionary);

            if (false !== $searchKeyFromDictionary) {
                $lastSuccessKey = $searchKeyFromDictionary;
                $keysForRemove = array_values($currentKeysForRemove);
            }

            if (false !== next($explodedSlug)) {
                continue;
            }

            if (array_key_exists($lastSuccessKey, $dictionary)) {
                array_push($result, $dictionary[$lastSuccessKey]);
            } else {
                array_shift($explodedSlug);
            }

            array_walk($keysForRemove, function($k) use (&$explodedSlug): void {
                unset($explodedSlug[$k]);
            });

            $currentSlugArray = [];
            $currentKeysForRemove = [];
            $keysForRemove = [];
            $lastSuccessKey = null;
            reset($explodedSlug);
        }

        return $result;
    }
}