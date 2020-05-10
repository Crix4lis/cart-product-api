<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Task\App\Cart\Domain\Event\CartEmptied;
use Task\App\Cart\Domain\Event\NewCartCreated;
use Task\App\Cart\Domain\Event\ProductAdded;
use Task\App\Cart\Domain\Event\ProductRemoved;
use Task\App\Cart\Domain\Exception\TooManyProductsInCartException;
use Task\App\Common\Event\AggregateWithEvents;
use Task\App\Common\Event\DomainEvent;

class Cart implements AggregateWithEvents
{
    public const MAX_ITEMS_PER_CART = 3;

    private string $cartId;
    /**
     * ArrayCollection of
     * @see \Task\App\Cart\Domain\Product
     */
    private ArrayCollection $productReferences;
    /** @var DomainEvent[] */
    private array $events = [];

    public static function createNewCart(string $cartId, Product $productInCart): Cart
    {
        $cart = new self($cartId, $productInCart);
        $cart->events[] = new NewCartCreated(
            $cart->getCartId(),
            current($cart->getProductReferences())->getProductId()
        );

        return $cart;
    }

    /**
     * @param Product $product
     *
     * @throws TooManyProductsInCartException
     */
    public function addProduct(Product $product): void
    {
        if (count($this->productReferences) === self::MAX_ITEMS_PER_CART) {
            throw new TooManyProductsInCartException(self::MAX_ITEMS_PER_CART, $this->getCartId());
        }

        $this->productReferences->add($product);
        $this->events[] = new ProductAdded($this->getCartId(), $product->getProductId());
    }

    public function removeProduct(Product $productToRemove): void
    {
        foreach ($this->productReferences as $key => $product) {
            if ($product->equals($product)) {
                $this->productReferences->remove($key);
                $this->events[] = new ProductRemoved($this->getCartId(), $product->getProductId());
                break;
            }
        }

        if ($this->productReferences->count() === 0) {
            $this->events[] = new CartEmptied($this->getCartId());
        }
    }

    private function __construct(string $cartId, Product... $productReferences)
    {
        $this->cartId = $cartId;
        $this->productReferences = new ArrayCollection($productReferences);
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    /** @return Product[] */
    public function getProductReferences(): array
    {
        return $this->productReferences->toArray();
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function clearEvents(): void
    {
        $this->events = [];
    }
}
