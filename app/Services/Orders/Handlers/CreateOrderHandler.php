<?php
/**
 * Description of CreateOrderHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Orders\Handlers;


use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Dots\DotsService;
use App\Services\Dots\DTO\OrderDTO;
use App\Services\Orders\Repositories\OrderRepositoryInterface;

class CreateOrderHandler
{

    /** @var DotsService */
    private $dotsService;
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        DotsService $dotsService,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->dotsService = $dotsService;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param CartDTO $cartDTO
     * @return Order
     */
    public function handle(CartDTO $cartDTO): Order
    {
        $orderData = $this->dotsService->makeOrder($this->generateDotsOrderData($cartDTO));

        return $this->orderRepository->createFromArray(
            $this->generateOrderData($cartDTO, $orderData)
        );
    }

    /**
     * @param CartDTO $cartDTO
     * @return array
     */
    private function generateDotsOrderData(CartDTO $cartDTO): array
    {
        return [
            'name' => $cartDTO->getUser()->getName(),
            'phone' => $cartDTO->getUser()->getPhone(),
            'deliveryType' => OrderDTO::DELIVERY_PICKUP,
            'typeOfPayment' => OrderDTO::PAYMENT_ONLINE,
            'type' => OrderDTO::TYPE_ORDERED_BY_API,
            'cart' => $this->generateDotsOrderCartData($cartDTO),
        ];
    }

    /**
     * @param CartDTO $cartDTO
     * @return array
     */
    private function generateDotsOrderCartData(CartDTO $cartDTO): array
    {
        $result = [];
        foreach ($cartDTO->getItems() as $item) {
            $result[] = [
                'id' => $item->getDishId(),
                'count' => $item->getCount(),
                'price' => $item->getPrice(),
            ];
        }
        return $result;
    }

    /**
     * @param CartDTO $cartDTO
     * @param array $dotsOrderData
     * @return array
     */
    private function generateOrderData(CartDTO $cartDTO, array $dotsOrderData): array
    {
        $data = $this->generateOrderDataFromCart($cartDTO);

        if (!empty($dotsOrderData['paymentRedirectUrl'])) {
            $data['paymentUrl'] = $dotsOrderData['paymentRedirectUrl'];
        }
        return $data;
    }

    /**
     * @param CartDTO $cartDTO
     * @return array
     */
    private function generateOrderDataFromCart(CartDTO $cartDTO): array
    {
        return [
            'userName' => $cartDTO->getUser()->getName(),
            'userPhone' => $cartDTO->getUser()->getPhone(),
            'user_id' => $cartDTO->getUser()->getId(),
            'items' => $cartDTO->getItemsArray()
        ];
    }

}
