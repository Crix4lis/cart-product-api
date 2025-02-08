<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Domain;

use Task\App\Catalogue\Domain\Event\NewProductCreated;
use Task\App\Catalogue\Domain\Event\ProductPriceChanged;
use Task\App\Catalogue\Domain\Event\ProductRemoved;
use Task\App\Catalogue\Domain\Event\ProductTitleChanged;
use Task\App\Common\Event\AggregateWithEvents;
use Task\App\Common\Event\DomainEvent;
use Task\App\Common\Price\Price;
use Webmozart\Assert\Assert;

class Product implements AggregateWithEvents
{
    private string $id;
    private string $title;
    private Price $price;
    private bool $isRemoved = false;
    /** @var DomainEvent[] */
    private array $events = [];

    /**
     * @param string $newProductId
     * @param string $newProductTitle
     * @param Price $newProductPrice
     *
     * @return Product
     *
     * @throws \InvalidArgumentException
     */
    public static function createNew(string $newProductId, string $newProductTitle, Price $newProductPrice): Product
    {
        Assert::uuid($newProductId);
        Assert::notEmpty($newProductTitle);
        Assert::greaterThan((int) $newProductPrice->getAmount(), 0);
        $newProduct = new self($newProductId, $newProductTitle, $newProductPrice);

        $newProduct->isRemoved = false;
        $newProduct->events[] = new NewProductCreated(
            $newProduct->getId(),
            $newProduct->getTitle(),
            $newProduct->getPrice()->getAmount(),
            $newProduct->getPrice()->getCurrency()
        );

        return $newProduct;
    }

    /**
     * @param string $newProductTitle
     *
     * @throws \InvalidArgumentException
     */
    public function changeProductTitle(string $newProductTitle): void
    {
        Assert::notEmpty($newProductTitle);
        $this->title = $newProductTitle;
        $this->events[] = new ProductTitleChanged($this->getId(), $this->getTitle());
    }

    /**
     * @param Price $newPrice
     *
     * @throws \InvalidArgumentException
     */
    public function changeProductPrice(Price $newPrice): void
    {
        Assert::greaterThan((int) $newPrice->getAmount(), 0);
        $this->price = $newPrice;
        $this->events[] = new ProductPriceChanged(
            $this->getId(),
            $this->getPrice()->getAmount(),
            $this->getPrice()->getCurrency()
        );
    }

    public function remove(): void
    {
        $this->isRemoved = true;
        $this->events[] = new ProductRemoved($this->getId());
    }

    private function __construct(string $id, string $title, Price $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function isToBeRemoved(): bool
    {
        return $this->isRemoved;
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
