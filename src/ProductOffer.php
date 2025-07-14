<?php

namespace Alex\Automag;

use Alex\Automag\Enum\ProductPriceTypesEnum;
use Alex\Automag\Enum\ProductLocationsTypesEnum;
use Money\Money;

final class ProductOffer
{
    private ?Money $retailPrice = null;

    public function __construct(
        public readonly int $id,
        public readonly Product $product,
        public readonly Supplier $supplier,
        public readonly int $amount,
        public readonly Money $supplierPrice,
        public readonly bool $discountless = false,
        public readonly ProductPriceTypesEnum $priceType = ProductPriceTypesEnum::RECOMMEND,
        public readonly ProductLocationsTypesEnum $location = ProductLocationsTypesEnum::REMOTE_WAREHOUSE
    ) {
    }

    public function setRetailPrice(Money $price): void
    {
        $this->retailPrice = $price;
    }

    public function getPrice(): ?Money
    {
        return $this->retailPrice;
    }
}
