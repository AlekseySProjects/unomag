<?php

namespace Alex\Automag;

final class ProductOffersCollection
{
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

    public function getAll()
    {
        return $this->offers;
    }

    public function count()
    {
        return $this->offers->count();
    }
}
