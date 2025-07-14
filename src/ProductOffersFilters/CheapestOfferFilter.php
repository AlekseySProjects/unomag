<?php

namespace Alex\Automag\ProductOffersFilters;

use Alex\Automag\ProductOffersCollection;
use Alex\Automag\ProductOffer;
use Money\Money;

final class CheapestOfferFilter implements ProductOffersFilterInterface
{
    public function filter(ProductOffersCollection $offers): ?ProductOffer
    {
        $cheapestPrice = null;
        $resultOffer = null;

        foreach ($offers->getAll() as $offer) {
            /** @var Money $price */
            $price = $offer->getPrice();

            if (!$cheapestPrice || $price->lessThan($cheapestPrice)) {
                $cheapestPrice = $price;
                $resultOffer = $offer;
            }
        }

        return $resultOffer;
    }
}
