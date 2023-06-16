<?php

declare(strict_types=1);

namespace App\Model;

use App\Interfaces\ResourceInterface;

class Product implements ResourceInterface
{
    private int $id;
    private string $name;
    private array $products = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getProducts(): array
    {
        return array_values($this->products);
    }

    public function hasProducts(): bool
    {
        return !empty($this->products);
    }

    public function addProduct(self $product): void
    {
        if (!$this->hasProduct($product)) {
            array_push($this->products, $product);
        }
    }

    public function removeProduct(self $product): void
    {
        if ($this->hasProduct($product)) {
            unset($this->products[$this->getKeyProduct($product)]);
        }
    }

    public function hasProduct(self $product): bool
    {
        if ($product->getId() === $this->getId()) {
            return true;
        }

        if (null !== $this->getKeyProduct($product)) {
            return true;
        }

        return false;
    }

    public function getKeyProduct(self $product): int|string|null
    {
        if (empty($keys = array_keys(array_filter($this->products, fn (self $p): bool => $p->getId() === $product->getId())))) {
            return null;
        }

        return $keys[array_key_first($keys)];
    }

    public function getProductById(int $id): ?self
    {
        if (empty($filteredProducts = array_filter($this->products, fn (self $product): bool => $product->getId() === $id))) {
            return null;
        }

        return $filteredProducts[array_key_first($filteredProducts)];
    }
}