<?php
declare(strict_types=1);

namespace Task\App\Cart\Infrastructure\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Task\App\Cart\Domain\Cart;

class GetAllCartsQuery extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function execute(): array
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            "SELECT c FROM Task\App\Cart\Domain\Cart c"
        );
        $result = $query->getResult(AbstractQuery::HYDRATE_ARRAY);

        $return = [];
        foreach ($result as $item) {
            $return[] = $item['cartId'];
        }

        return $return;
    }
}
