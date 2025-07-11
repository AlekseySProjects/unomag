<?php
namespace Tests;

use Money\Money;
use Alex\Automag\Product;
use Alex\Automag\Supplier;
use Alex\Automag\ProductOffer;
use PHPUnit\Framework\TestCase;
use Alex\Automag\Enum\SuppliersTypesEnum;
use Alex\Automag\RetailPriceCalculator;

class RetailPriceCalculatorTest extends TestCase {
    protected $products;
    protected $suppliers;
    protected $calculator;

    public function setUp(): void
    {
        $this->calculator = new RetailPriceCalculator();
        $this->products = [
            'CHEVROLET'  => new Product(id: 1, article: '71206', name: 'CHEVROLET Camaro ZL1 (2017), summit white'),
        ];

        $this->suppliers = [
            'dm'  => new Supplier(id: 1, name: 'Детский мир', type: SuppliersTypesEnum::BIG),
        ];
    }

    public function test_price_499() {

        $offer = new ProductOffer(
            id: 1,
            product: $this->products['CHEVROLET'],
            supplier: $this->suppliers['dm'],
            amount: 5,
            supplierPrice: Money::RUB(49900),
        );

        $expected = Money::RUB(72355); // (+45%) 723.55 руб

        $this->calculator->calculatePriceWithInterestRate($offer);
        $this->assertTrue($expected->equals($offer->getPrice()));
    }
    
    public function test_price_500() {

        $offer = new ProductOffer(
            id: 1,
            product: $this->products['CHEVROLET'],
            supplier: $this->suppliers['dm'],
            amount: 5,
            supplierPrice: Money::RUB(50000),
        );

        $expected = Money::RUB(70000); // (+40%) 700 руб

        $this->calculator->calculatePriceWithInterestRate($offer);
        $this->assertTrue($expected->equals($offer->getPrice()));
    }
    
    public function test_price_without_rate() {

        $offer = new ProductOffer(
            id: 1,
            product: $this->products['CHEVROLET'],
            supplier: $this->suppliers['dm'],
            amount: 5,
            supplierPrice: Money::RUB(500000), // 5 000
        );

        $expected = Money::RUB(625000); // (+25%) 6 250 руб

        $this->calculator->calculatePriceWithInterestRate($offer);
        $this->assertTrue($expected->equals($offer->getPrice()));
    }
    
    public function test_discountless_price() {

        $offer = new ProductOffer(
            id: 1,
            product: $this->products['CHEVROLET'],
            supplier: $this->suppliers['dm'],
            amount: 5,
            supplierPrice: Money::RUB(10000), // 1 000
            discountless: true
        );

        $expected = Money::RUB(15000); // (+50%) 1 500 руб

        $this->calculator->calculatePriceWithInterestRate($offer);
        $this->assertTrue($expected->equals($offer->getPrice()));
    }
}
