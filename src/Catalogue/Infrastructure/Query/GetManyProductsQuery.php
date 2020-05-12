<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Infrastructure\Query;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Task\App\Catalogue\Domain\Product;
use Task\App\Catalogue\Infrastructure\Parser\SingleProductParser;
use Task\App\Common\Exception\InvalidInputException;

class GetManyProductsQuery extends ServiceEntityRepository
{
    public const PER_PAGE = 3;
    private SingleProductParser $parser;

    public function __construct(ManagerRegistry $registry, SingleProductParser $parser)
    {
        parent::__construct($registry, Product::class);
        $this->parser = $parser;
    }

    /**
     * @return array
     *
     * @param int $page
     *
     * @throws InvalidInputException
     */
    public function execute(int $page): array
    {
        if ($page <= 0) {
            throw new InvalidInputException("Page query parameter must be over 0");
        }

        $offset = ($page - 1) * self::PER_PAGE;

        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT p FROM Task\App\Catalogue\Domain\Product p");
        $query->setMaxResults(self::PER_PAGE)->setFirstResult($offset);
        $result = $query->getResult(AbstractQuery::HYDRATE_ARRAY);

        $return = [];
        foreach ($result as $product) {
            $return[] = $this->parser->parse($product);
        }

        return $return;
    }
}
