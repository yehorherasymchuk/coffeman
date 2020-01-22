<?php
/**
 * Description of OrderMessageGenerator.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Generators;


use App\Models\Order;

class OrderMessageGenerator
{

    /**
     * @param Order $order
     * @return string
     */
    public function generate(Order $order): string
    {
        return sprintf(
            'Name: %s' . PHP_EOL .
            'Phone: %s' . PHP_EOL .
            'Items: %s',
            $order->userName,
            $order->userPhone,
            $this->generateOrderItemsMessage($order)
        );
    }

    /**
     * @param Order $order
     * @return string
     */
    private function generateOrderItemsMessage(Order $order): string
    {
        $result = [];
        foreach ($order->items as $item) {
            $result[] = $this->generateOrderItemMessage($item);
        }
        return implode(PHP_EOL, $result);
    }

    /**
     * @param array $item
     * @return string
     */
    private function generateOrderItemMessage(array $item): string
    {
        return sprintf(
            '%s - %s',
            $item['name'],
            $item['count']
        );
    }

}
