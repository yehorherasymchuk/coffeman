<?php
/**
 * Description of OrdersService.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Orders;


use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Orders\Handlers\CreateOrderHandler;
use App\Services\Orders\Repositories\OrderRepositoryInterface;

class OrdersService
{

    /** @var CreateOrderHandler */
    private $createOrderHandler;
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        CreateOrderHandler $createOrderHandler,
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->createOrderHandler = $createOrderHandler;
        $this->orderRepository = $orderRepository;
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
