<?php
/**
 * Description of CartService.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Cart;


use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Cart\Handlers\CreateOrderHandler;
use App\Services\Cart\Repositories\CartRepositoryInterface;

class CartService
{

    /** @var CreateOrderHandler */
    private $createOrderHandler;
    /** @var CartRepositoryInterface */
    private $cartRepository;

    public function __construct(
        CreateOrderHandler $createOrderHandler,
        CartRepositoryInterface $cartRepository
    )
    {
        $this->createOrderHandler = $createOrderHandler;
        $this->cartRepository = $cartRepository;
    }

    public function getOrCreateCart(string $key, array $data = []): CartDTO
    {
        $cart = $this->cartRepository->findByKey($key);
        if (!$cart) {
            $cart = $this->create(CartDTO::fromArray(array_merge([
                'key' => $key,
            ], $data)));
        }
        return $cart;
    }

    /**
     * @param CartDTO $cartDTO
     * @return CartDTO
     */
    public function create(CartDTO $cartDTO): CartDTO
    {
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @param array $item
     * @return CartDTO
     */
    public function addItem(CartDTO $cartDTO, array $item): CartDTO
    {
        $cartDTO->addItem($item);
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @return CartDTO
     */
    public function storeCart(CartDTO $cartDTO): CartDTO
    {
        return $this->cartRepository->store($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @return Order
     */
    public function createOrder(CartDTO $cartDTO): Order
    {
        return $this->createOrderHandler->handle($cartDTO);
    }

}
