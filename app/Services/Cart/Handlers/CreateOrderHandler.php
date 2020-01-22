<?php
/**
 * Description of CreateOrderHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Cart\Handlers;


use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Cart\Repositories\CartRepositoryInterface;
use App\Services\Dots\DotsService;
use App\Services\Orders\OrdersService;

class CreateOrderHandler
{

    /** @var OrdersService */
    private $ordersService;
    /** @var CartRepositoryInterface */
    private $cartRepository;

    public function __construct(
        OrdersService $ordersService,
        CartRepositoryInterface $cartRepository
    )
    {
        $this->ordersService = $ordersService;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param CartDTO $cartDTO
     * @return Order
     */
    public function handle(CartDTO $cartDTO): Order
    {
        $order = $this->ordersService->createOrder($cartDTO);
        $this->cartRepository->clear($cartDTO);
        return $order;
    }

}
