<?php
/**
 * Description of AddCartItemHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Handlers;


use App\Services\Cart\CartService;
use App\Services\Telegram\Resolvers\TelegramMessageCartResolver;
use Longman\TelegramBot\Entities\Message;

class AddCartItemHandler
{

    /** @var TelegramMessageCartResolver */
    private $telegramMessageCartResolver;
    /** @var CartService */
    private $cartService;

    public function __construct(
        TelegramMessageCartResolver $telegramMessageCartResolver,
        CartService $cartService
    )
    {
        $this->telegramMessageCartResolver = $telegramMessageCartResolver;
        $this->cartService = $cartService;
    }

    public function handle(Message $message, array $dish)
    {
        $cart = $this->telegramMessageCartResolver->resolve($message);

        $this->cartService->addItem($cart, [
            'dish_id' => $dish['id'],
            'name' => $dish['name'],
            'price' => $dish['price'],
        ]);
        return $cart;
    }

}
