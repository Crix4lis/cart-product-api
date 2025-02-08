<?php
declare(strict_types=1);

namespace Task\App\Cart\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Task\App\Cart\Domain\Cart;
use Task\App\Cart\Domain\Carts;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

class DoctrineCarts extends ServiceEntityRepository implements Carts
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /**
     * @param string $cartId
     * @return Cart
     *
     * @throws NotFoundException
     */
    public function getById(string $cartId): Cart
    {
        /** @var Cart $cart */
        $cart = $this->find($cartId);

        if ($cart === null) {
            throw new NotFoundException();
        }

        return $cart;
    }

    /**
     * @param Cart $cart
     *
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function save(Cart $cart): void
    {
        if ($cart->isEmpty()) {
            $this->remove($cart);
            return;
        }

        $em = $this->getEntityManager();

        try {
            $em->persist($cart);
            $em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new ConflictException(sprintf("Cart with id %s already exists", $cart->getCartId()));
        } catch (\Exception $e) {
            throw new DataLayerException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function remove(Cart $toRm) {
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
