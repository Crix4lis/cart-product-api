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
use Task\App\Catalogue\Infrastructure\Query\GetManyQuery;
use Task\App\Catalogue\UI\Validator\CreateProductValidator;
use Task\App\Catalogue\UI\Validator\EditProductValidator;
use Task\App\Catalogue\UI\Validator\ProductBaseValidator;
use Task\App\Common\Exception\InvalidInputException;
use Task\App\Common\Generator\UuidGenerator;
use Task\App\Common\Parser\Parser;

class CatalogueRestController extends AbstractController
{
    public function create(
        Request $request,
        CommandBus $commandBus,
        Parser $parser,
        CreateProductValidator $validator,
        UuidGenerator $uuidGenerator
    ): JsonResponse
    {
        $data = $parser->parse($request->getContent());
        if (false === $validator->validate($data)) {
            throw new InvalidInputException();
        }

        $newProductId = $uuidGenerator->generate();
        $cmd = new CreateNewProductCommand(
            $newProductId,
            ProductBaseValidator::TITLE_KEY,
            ProductBaseValidator::AMOUNT_KEY
        );
//        try {
            $commandBus->handle($cmd);
//        } catch () {
//            throw new ConflictException(sprintf("Product with title %s already exists", $data['title']));
//        }

        return new JsonResponse(
            ['new_product_id' => $newProductId],
            201,
            ["Location" => $this->generateUrl('catalogue_get_product', ['id' => $newProductId])]
        );
    }

    public function remove(
        string $id,
        CommandBus $commandBus
    ): JsonResponse
    {
        $cmd = new RemoveProductCommand($id);
//        try {
            $commandBus->handle($cmd);
//        } catch () {
//            throw new NotFoundException();
//        }

        return new JsonResponse([],200);
    }

    public function edit(
        Request $request,
        CommandBus $commandBus,
        Parser $parser,
        EditProductValidator $validator
    ): JsonResponse
    {
        $data = $parser->parse($request->getContent());
        if (false === $validator->validate($data)) {
            throw new InvalidInputException();
        }

        $cmd = new EditProductCommand(
            ProductBaseValidator::ID_KEY,
            ProductBaseValidator::TITLE_KEY,
            ProductBaseValidator::AMOUNT_KEY
        );
//        try {
            $commandBus->handle($cmd);
//        } catch () {
//            throw new ConflictException(sprintf("Product with title %s already exists", $data['title']));
//        } catch () {
//            throw new NotFoundException();
//        }

        return new JsonResponse();
    }

    public function getList(Request $request, GetManyQuery $query): JsonResponse
    {
        $page = $request->query->getInt('page', 1);

        return new JsonResponse('OK');

//        try {
            $result = $query->execute($page);
//        } catch () {
//            throw new NotFoundException();
//        }

        return new JsonResponse($request);
    }
}
