<?php

namespace Alex\Automag;

use Alex\Automag\Enum\SuppliersTypesEnum;

final class Supplier
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly SuppliersTypesEnum $type
    ) {
    }
}
