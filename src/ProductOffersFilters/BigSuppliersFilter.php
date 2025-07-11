<?php

namespace Alex\Automag\ProductOffersFilters;

use Alex\Automag\Enum\SuppliersTypesEnum;
use Alex\Automag\ProductOffersCollection;
use Alex\Automag\Enum\ProductPriceTypesEnum;

class BigSuppliersWithCustomPriceFilter implements ProductOffersFilterInterface
{
    public function filter(ProductOffersCollection $offers): ProductOffersCollection
    {
        $filteredOffers = new ProductOffersCollection($offers->offeredProduct);
        foreach ($offers->getAll() as $offer) {
            $isBig = $offer->supplier->type === SuppliersTypesEnum::BIG;
            $isCustomPrice = $offer->priceType === ProductPriceTypesEnum::CUSTOM;

            if ($isBig && $isCustomPrice) {
                $filteredOffers->add($offer);
            }
        }
        return $filteredOffers;
    }
}
