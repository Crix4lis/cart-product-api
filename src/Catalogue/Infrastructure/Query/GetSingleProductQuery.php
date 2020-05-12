<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Infrastructure\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Task\App\Catalogue\Domain\Product;
use Task\App\Catalogue\Infrastructure\Parser\SingleProductParser;
use Task\App\Common\Exception\NotFoundException;

class GetSingleProductQuery extends ServiceEntityRepository
{
    private SingleProductParser $parser;

    public function __construct(ManagerRegistry $registry, SingleProductParser $parser)
    {
        parent::__construct($registry, Product::class);
        $this->parser = $parser;
    }

    /**
     * @param string $productId
     * @return array
     *
     * @throws NotFoundException
     */
    public function execute(string $productId): array
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT p FROM Task\App\Catalogue\Domain\Product p WHERE p.id = :uuid");
        $query->setParameter('uuid', $productId);
        $result = $query->getResult(AbstractQuery::HYDRATE_ARRAY);

        if (empty($result)) {
            throw new NotFoundException();
        }

        return $this->parser->parse(current($result));
    }
}
