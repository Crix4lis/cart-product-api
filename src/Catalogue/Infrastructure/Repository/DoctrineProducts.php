<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Task\App\Catalogue\Domain\Product;
use Task\App\Catalogue\Domain\Products;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

class DoctrineProducts extends ServiceEntityRepository implements Products
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param string $productId
     * @return Product
     *
     * @throws NotFoundException
     */
    public function getById(string $productId): Product
    {
        /** @var Product $product */
        $product = $this->find($productId);

        if ($product === null) {
            throw new NotFoundException();
        }

        return $product;
    }

    /**
     * @param Product $product
     *
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function save(Product $product): void
    {
        if ($product->isToBeRemoved()) {
            $this->remove($product);
            return;
        }

        $em = $this->getEntityManager();

        try {
            $em->persist($product);
            $em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new ConflictException();
        } catch (\Exception $e) {
            throw new DataLayerException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function remove(Product $toRm) {
        $em = $this->getEntityManager();

        try {
            $em->remove($toRm);
            $em->flush();
        } catch (\Exception $e) {
            throw new DataLayerException();
        }

        return;
    }
}
