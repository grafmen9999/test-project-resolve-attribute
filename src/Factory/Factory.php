<?php

declare(strict_types=1);

namespace App\Factory;

use App\Interfaces\FactoryInterface;
use App\Interfaces\ResourceInterface;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

class Factory implements FactoryInterface
{
    public function __construct(
        protected string $class = '',
    ) {
    }

    public function create(): ResourceInterface
    {
        if (class_exists($this->class)) {
            return new $this->class;
        }

        throw new ClassNotFoundException($this->class);
    }
}