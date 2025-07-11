<?php

namespace Alex\Automag;

use Alex\Automag\ProductOffer;
use Alex\Automag\RetailPriceCalculator;
use Alex\Automag\ProductOffersCollection;
use Alex\Automag\ProductOffersFilters\OwnWarehouseFilter;
use Alex\Automag\ProductOffersFilters\CheapestOfferFilter;

final class ProductPriceManager
{
    public static function getRetailOffer(ProductOffersCollection $offers): ?ProductOffer
    {
        $ownWarehouseFilter = new OwnWarehouseFilter();
        $ownWarehouseOffers = $ownWarehouseFilter->filter($offers);

        if ($ownWarehouseOffers->count()) { // если есть на складе, то сужаем предложения
            $offers = $ownWarehouseOffers;
        }

        $priceCalculator = new RetailPriceCalculator();
        $priceCalculator->calculate($offers);

        $CheapestOfferFilter = new CheapestOfferFilter();
        return $CheapestOfferFilter->filter($offers);
    }
}
