<?php

namespace Alex\Automag;

final class ProductOffersCollection
{
    /**
	 * @var \SplObjectStorage<ProductOffer, null> $offers
	 */
    private \SplObjectStorage $offers;

    public function __construct(
        public readonly Product $offeredProduct,
    ) {
        $this->offers = new \SplObjectStorage();
    }

    public function add(ProductOffer $offer): self
    {
        if ($offer->product !== $this->offeredProduct) {
            throw new \Error('Вы пытаетесь добавить предложение по другому товару');
        }

        $this->offers->attach($offer);

        return $this;
    }

    /** @return \SplObjectStorage<ProductOffer, null> */
    public function getAll(): \SplObjectStorage
    {
        return $this->offers;
    }

    public function count(): int
    {
        return $this->offers->count();
    }
}
