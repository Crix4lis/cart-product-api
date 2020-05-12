<?php
declare(strict_types=1);

namespace Task\App\Catalogue\UI\Controller;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Task\App\Catalogue\Application\CreateNewProductCommand;
use Task\App\Catalogue\Application\EditProductCommand;
use Task\App\Catalogue\Application\RemoveProductCommand;
use Task\App\Catalogue\Infrastructure\Query\GetManyProductsQuery;
use Task\App\Catalogue\Infrastructure\Query\GetSingleProductQuery;
use Task\App\Catalogue\UI\Validator\CreateProductValidator;
use Task\App\Catalogue\UI\Validator\EditProductValidator;
use Task\App\Catalogue\UI\Validator\ProductBaseValidator;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\InvalidInputException;
use Task\App\Common\Exception\NotFoundException;
use Task\App\Common\Generator\UuidGenerator;
use Task\App\Common\Parser\Parser;

class CatalogueRestController extends AbstractController
{
    /**
     * @param Request $request
     * @param CommandBus $commandBus
     * @param Parser $parser
     * @param CreateProductValidator $validator
     * @param UuidGenerator $uuidGenerator
     *
     * @return JsonResponse
     *
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     * @throws InvalidInputException
     */
    public function create(
        Request $request,
        CommandBus $commandBus,
        Parser $parser,
        CreateProductValidator $validator,
        UuidGenerator $uuidGenerator
    ): JsonResponse
    {
        $data = $parser->parse($request->getContent());
        $validator->validate($data);

        $newProductId = $uuidGenerator->generate();
        $cmd = new CreateNewProductCommand(
            $newProductId,
            $data[ProductBaseValidator::TITLE_KEY],
            $data[ProductBaseValidator::AMOUNT_KEY]
        );
        $commandBus->handle($cmd);

        return new JsonResponse(
            ['new_product_id' => $newProductId],
            201,
            ["Location" => $this->generateUrl('catalogue_get_product', ['id' => $newProductId])]
        );
    }

    /**
     * @param string $id
     * @param CommandBus $commandBus
     *
     * @return JsonResponse
     *
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     * @throws InvalidInputException
     */
    public function remove(
        string $id,
        CommandBus $commandBus
    ): JsonResponse
    {
        $cmd = new RemoveProductCommand($id);
        $commandBus->handle($cmd);

        return new JsonResponse([],200);
    }

    /**
     * @param string $id
     * @param Request $request
     * @param CommandBus $commandBus
     * @param Parser $parser
     * @param EditProductValidator $validator
     *
     * @return JsonResponse
     *
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     * @throws InvalidInputException
     */
    public function edit(
        string $id,
        Request $request,
        CommandBus $commandBus,
        Parser $parser,
        EditProductValidator $validator
    ): JsonResponse
    {
        $data = $parser->parse($request->getContent());
        $validator->validate($data);

        $cmd = new EditProductCommand(
            $id,
            $data[ProductBaseValidator::TITLE_KEY] ?? null,
            $data[ProductBaseValidator::AMOUNT_KEY] ?? null
        );
        $commandBus->handle($cmd);

        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @param GetManyProductsQuery $query
     *
     * @return JsonResponse
     *
     * @throws InvalidInputException
     */
    public function getList(Request $request, GetManyProductsQuery $query): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $result = $query->execute($page);

        return new JsonResponse($result);
    }

    /**
     * @param string $id
     * @param GetSingleProductQuery $query
     *
     * @return JsonResponse
     *
     * @throws NotFoundException
     */
    public function getSingle(string $id, GetSingleProductQuery $query): JsonResponse
    {
        $result = $query->execute($id);

        return new JsonResponse($result);
    }
}
