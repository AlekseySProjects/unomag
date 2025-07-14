<?php

namespace Alex\Automag;

use Money\Money;

final class RetailPriceCalculator
{
    public function calculate(ProductOffersCollection $offers): void
    {
        foreach ($offers->getAll() as $offer) {
            $this->calculatePriceWithInterestRate($offer);
        }
    }

    public function calculatePriceWithInterestRate(ProductOffer $offer): void
    {
        $rate = $offer->discountless ? '50' : (float) $this->getRateByPrice($offer->supplierPrice);
        $rate /= 100;
        $rate = (string) $rate;

        $retailPrice = $offer->supplierPrice->add(
            $offer->supplierPrice->multiply($rate)
        );

        $offer->setRetailPrice($retailPrice);
    }

    private function getRateByPrice(Money $price): string
    {
        $defaultRate = '25';

        $steps = [
            '45' => Money::RUB('50000'), // 500 руб
            '40' => Money::RUB('100000'), // 1000 руб
            '35' => Money::RUB('500000'), // 5000 руб
        ];

        foreach ($steps as $rate => $upperLimit) {
            if ($price->lessThan($upperLimit)) {
                return (string) $rate;
            }
        }

        return $defaultRate;
    }
}
