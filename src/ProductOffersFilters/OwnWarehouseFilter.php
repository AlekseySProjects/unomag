<?php

namespace Alex\Automag\ProductOffersFilters;

use Alex\Automag\ProductOffersCollection;
use Alex\Automag\Enum\ProductLocationsTypesEnum;

final class OwnWarehouseFilter implements ProductOffersFilterInterface
{
    public function filter(ProductOffersCollection $offers): ProductOffersCollection
    {
        $filteredOffers = new ProductOffersCollection($offers->offeredProduct);
        foreach ($offers->getAll() as $offer) {
            if ($offer->location === ProductLocationsTypesEnum::OWN_WAREHOUSE) {
                $filteredOffers->add($offer);
            }
        }
        return $filteredOffers;
    }
}
