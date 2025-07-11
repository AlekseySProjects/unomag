<?php

namespace Alex\Automag;

final class Product
{
    public function __construct(
        public readonly int $id,
        public readonly string $article,
        public readonly string $name
    ) {
    }
}
