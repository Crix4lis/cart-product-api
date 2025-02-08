<?php
declare(strict_types=1);

namespace Task\App\Cart\Infrastructure\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Task\App\Cart\Domain\Cart;
use Task\App\Catalogue\Infrastructure\Parser\SingleProductParser;
use Task\App\Common\Exception\InvalidInputException;
use Task\App\Common\Exception\NotFoundException;

class GetCartProductsQuery extends ServiceEntityRepository
{
    public const PER_PAGE = 3;
    private SingleProductParser $parser;

    public function __construct(ManagerRegistry $registry, SingleProductParser $parser)
    {
        parent::__construct($registry, Cart::class);
        $this->parser = $parser;
    }

    /**
     * @param string $cartUuid
     * @param int $page
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function execute(string $cartUuid, int $page): array
    {
        if ($page <= 0) {
            throw new InvalidInputException("page query parameter must be over 0");
        }

        $offset = ($page - 1) * self::PER_PAGE;

        $em = $this->getEntityManager();
        $this->getEntityManager();

        $query = $em->createQuery(
            "SELECT c FROM Task\App\Cart\Domain\Cart c WHERE c.cartId = :cartUuid"
        );
        $query->setParameter('cartUuid', $cartUuid);
        /** @var Cart[] $cart */
        $cart = $query->getResult();

        if (empty($cart)) {
            throw new NotFoundException();
        }

        $pRefs = current($cart)->getProductReferences();
        $products = [];
        foreach ($pRefs as $p) {
            $products[] = $p->getProductId();
        }

        $query = $em->createQuery(
            "SELECT p FROM Task\App\Catalogue\Domain\Product p WHERE p.id IN (:ids)"
        );
        $query->setMaxResults(self::PER_PAGE)->setFirstResult($offset);
        $result = $query->execute(['ids' => $products], AbstractQuery::HYDRATE_ARRAY);

        $toReturnData = [];
        foreach ($result as $p) {
            $toReturnData[] = $this->parser->parse($p);
        }

        $toReturnData['cart_total_price_amount'] = $this->getTotalPrice($products);
        $toReturnData['cart_total_price_currency'] = 'USD';

        return $toReturnData;
    }

    private function getTotalPrice(array $forProductIds): string
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT sum(p.price.surrogateAmount) FROM Task\App\Catalogue\Domain\Product p WHERE p.id IN (:ids)"
        );
        $price = current(current($query->execute(['ids' => $forProductIds], AbstractQuery::HYDRATE_ARRAY)));

        $price = (float) ($price / 100);
        $price = (string) $price;
        $exploded = explode('.', $price);

        if (false === array_key_exists(1, $exploded)) {
            return $price . '.00';
        }

        if (strlen($exploded[1]) === 1) {
            return $price . '0';
        }

        return $price;
    }
}
