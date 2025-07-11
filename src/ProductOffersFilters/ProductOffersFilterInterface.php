<?php

namespace Alex\Automag\ProductOffersFilters;

use Alex\Automag\ProductOffersCollection;
use Alex\Automag\ProductOffer;

interface ProductOffersFilterInterface
{
    public function filter(ProductOffersCollection $offers): ProductOffersCollection|ProductOffer;
}
