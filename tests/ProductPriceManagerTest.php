<?php

namespace Tests;

use Money\Money;
use Alex\Automag\Product;
use Alex\Automag\Supplier;
use Alex\Automag\ProductOffer;
use PHPUnit\Framework\TestCase;
use Alex\Automag\ProductPriceManager;
use Alex\Automag\Enum\SuppliersTypesEnum;
use Alex\Automag\ProductOffersCollection;
use Alex\Automag\Enum\ProductLocationsTypesEnum;

class ProductPriceManagerTest extends TestCase
{
    /** @var array<string, Product> $products */
    protected array $products;

    /** @var array<string, Supplier> $suppliers */
    protected array $suppliers;

    public function setUp(): void
    {

        $this->products = [
            'CHEVROLET'  => new Product(id: 1, article: '71206', name: 'CHEVROLET Camaro ZL1 (2017), summit white'),
            'TOYOTA'     => new Product(2, '65521', 'TOYOTA Hilux Pick-up (1984), white'),
            'MITSUBISHI' => new Product(3, '65105', 'MITSUBISHI Galant VR-4 RHD (1988), dark blue'),
        ];

        $this->suppliers = [
            'dm'  => new Supplier(id: 1, name: 'Детский мир', type: SuppliersTypesEnum::BIG),
            'mg'  => new Supplier(2, 'Машиноград', SuppliersTypesEnum::SMALL),
            'iii' => new Supplier(3, 'Иванов Иван Иванович', SuppliersTypesEnum::PERSON),
            'kr'  => new Supplier(4, 'Кораблик', SuppliersTypesEnum::BIG),
        ];
    }

    public function test_exists_in_warehouse(): void
    {
        $suppliers = $this->suppliers;
        $products = $this->products;
        $offersCollection = new ProductOffersCollection($products['CHEVROLET']);

        $expectedOffer = new ProductOffer(
            id: 3,
            product: $products['CHEVROLET'],
            supplier: $suppliers['mg'],
            amount: 3,
            supplierPrice: Money::RUB(63300), // 633 руб
            location: ProductLocationsTypesEnum::OWN_WAREHOUSE
        );

        $offersCollection->add(
            new ProductOffer(
                id: 1,
                product: $products['CHEVROLET'],
                supplier: $suppliers['dm'],
                amount: 10,
                supplierPrice: Money::RUB(109950), // 1099.50 руб
                location: ProductLocationsTypesEnum::OWN_WAREHOUSE
            )
        )
        ->add(
            new ProductOffer(
                id: 2,
                product: $products['CHEVROLET'],
                supplier: $suppliers['kr'],
                amount: 10,
                supplierPrice: Money::RUB(40000), // 400 руб
            )
        )
        ->add(
            $expectedOffer
        );

        $this->assertSame($expectedOffer, ProductPriceManager::getRetailOffer($offersCollection));
    }

    public function test_cheapest_from_suppliers_if_not_exists_in_warehouse(): void
    {
        $suppliers = $this->suppliers;
        $products = $this->products;
        $offersCollection = new ProductOffersCollection($products['CHEVROLET']);

        $expectedOffer = new ProductOffer(
            id: 2,
            product: $products['CHEVROLET'],
            supplier: $suppliers['kr'],
            amount: 10,
            supplierPrice: Money::RUB(40000), // 400 руб
        );

        $offersCollection->add(
            new ProductOffer(
                id: 1,
                product: $products['CHEVROLET'],
                supplier: $suppliers['dm'],
                amount: 10,
                supplierPrice: Money::RUB(109950), // 1099.50 руб
            )
        )
        ->add(
            new ProductOffer(
                id: 3,
                product: $products['CHEVROLET'],
                supplier: $suppliers['mg'],
                amount: 3,
                supplierPrice: Money::RUB(63300), // 633 руб
            )
        )
        ->add(
            $expectedOffer
        );

        $this->assertSame($expectedOffer, ProductPriceManager::getRetailOffer($offersCollection));
    }
}
