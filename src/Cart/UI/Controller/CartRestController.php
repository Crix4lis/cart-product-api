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
use Task\App\Cart\Domain\Exception\ProductNotFoundInCart;
use Task\App\Cart\Domain\Exception\TooManyProductsInCartException;
use Task\App\Cart\Infrastructure\Query\GetCartProductsQuery;
use Task\App\Cart\UI\Validator\AddProductValidator;
use Task\App\Cart\UI\Validator\CartBaseValidator;
use Task\App\Cart\UI\Validator\CreateCartValidator;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\InvalidInputException;
use Task\App\Common\Exception\NotFoundException;
use Task\App\Common\Generator\UuidGenerator;
use Task\App\Common\Parser\Parser;

class CartRestController extends AbstractController
{
    /**
     * @param Request $request
     * @param CommandBus $commandBus
     * @param Parser $parser
     * @param CreateCartValidator $validator
     * @param UuidGenerator $uuidGenerator
     *
     * @return JsonResponse
     *
     * @throws InvalidInputException
     * @throws ConflictException
     * @throws DataLayerException
     * @throws InvalidInputException
     */
    public function create(
        Request $request,
        CommandBus $commandBus,
        Parser $parser,
        CreateCartValidator $validator,
        UuidGenerator $uuidGenerator
    ): JsonResponse
    {
        $data = $parser->parse($request->getContent());
        $validator->validate($data);

        $newCartId = $uuidGenerator->generate();
        $cmd = new CreateNewCartCommand($newCartId, $data[CartBaseValidator::PRODUCT_REFERENCE_KEY]);
        $commandBus->handle($cmd);

        return new JsonResponse(
            ['new_cart_id' => $newCartId],
            201,
            ["Location" => $this->generateUrl('cart_get_cart_products', ['id' => $newCartId])]
        );
    }

    /**
     * @param string $id
     * @param Request $request
     * @param Parser $parser
     * @param CommandBus $commandBus
     * @param AddProductValidator $validator
     *
     * @return JsonResponse
     *
     * @throws InvalidInputException
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     * @throws TooManyProductsInCartException
     */
    public function addProduct(
        string $id,
        Request $request,
        Parser $parser,
        CommandBus $commandBus,
        AddProductValidator $validator
    ): JsonResponse
    {
        $data = $parser->parse($request->getContent());
        $validator->validate($data);

        $cmd = new AddProductToCartCommand($id, $data[AddProductValidator::PRODUCT_REFERENCE_KEY]);
        $commandBus->handle($cmd);

        return new JsonResponse();
    }

    /**
     * @param string $id
     * @param string $productId
     * @param CommandBus $commandBus
     *
     * @return JsonResponse
     *
     * @throws NotFoundException
     * @throws ProductNotFoundInCart
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function removeProduct(
        string $id,
        string $productId,
        CommandBus $commandBus
    ): JsonResponse
    {
        $cmd = new RemoveProductFromCartCommand($id, $productId);
        $commandBus->handle($cmd);

        return new JsonResponse();
    }

    /**
     * @param string $id
     * @param Request $request
     * @param GetCartProductsQuery $query
     *
     * @return JsonResponse
     *
     * @throws NotFoundException
     */
    public function getCartProducts(
        string $id,
        Request $request,
        GetCartProductsQuery $query
    ): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $result = $query->execute($id, $page);

        return new JsonResponse($result);
    }
}
