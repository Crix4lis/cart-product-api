<?php
declare(strict_types=1);

namespace Task\App\Cart\UI\Controller;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Task\App\Cart\Application\AddProductToCartCommand;
use Task\App\Cart\Application\CreateNewCartCommand;
use Task\App\Cart\Application\RemoveProductFromCartCommand;
use Task\App\Cart\Infrastructure\GetCartProductsQuery;
use Task\App\Cart\UI\Validator\AddProductValidator;
use Task\App\Cart\UI\Validator\CartBaseValidator;
use Task\App\Cart\UI\Validator\CreateCartValidator;
use Task\App\Common\Exception\InvalidInputException;
use Task\App\Common\Generator\UuidGenerator;
use Task\App\Common\Parser\Parser;

class CartRestController extends AbstractController
{
    public function create(
        Request $request,
        CommandBus $commandBus,
        Parser $parser,
        CreateCartValidator $validator,
        UuidGenerator $uuidGenerator
    ): JsonResponse
    {
        $data = $parser->parse($request->getContent());
        if (false === $validator->validate($data)) {
            throw new InvalidInputException();
        }

        $newCartId = $uuidGenerator->generate();
        $cmd = new CreateNewCartCommand($newCartId, $data[CartBaseValidator::PRODUCT_REFERENCE_KEY]);
            //        try {
            $commandBus->handle($cmd);
//        } catch () {
//            throw new ConflictException(sprintf("Product with title %s already exists", $data['title']));
//        }

        return new JsonResponse(
            ['new_cart_id' => $newCartId],
            201,
            ["Location" => $this->generateUrl('cart_get_cart_products', ['id' => $newCartId])]
        );
    }

    public function addProduct(
        string $id,
        Request $request,
        Parser $parser,
        CommandBus $commandBus,
        AddProductValidator $validator
    ): JsonResponse
    {
        $data = $parser->parse($request->getContent());
        if (false === $validator->validate($data)) {
            throw new InvalidInputException();
        }

        $cmd = new AddProductToCartCommand($id, $data[AddProductValidator::PRODUCT_REFERENCE_KEY]);
        //        try {
        $commandBus->handle($cmd);
//        } catch () {
//            throw new NotFoundException();
//        }

        return new JsonResponse();
    }

    public function removeProduct(
        string $id,
        string $productId,
        CommandBus $commandBus
    ): JsonResponse
    {
        $cmd = new RemoveProductFromCartCommand($id, $productId);
        //        try {
        $commandBus->handle($cmd);
//        } catch () {
//            throw new NotFoundException();
//        }

        return new JsonResponse();
    }

    public function getCartProducts(
        string $id,
        Request $request,
        GetCartProductsQuery $query
    ): JsonResponse
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
