<?php
/**
 * Description of CreateTelegramOrderHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Handlers;


use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Dots\DotsService;
use App\Services\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Services\Telegram\Senders\MessageSender;
use Longman\TelegramBot\Entities\Message;

class CreateTelegramOrderHandler
{

    /** @var TelegramMessageCartResolver */
    private $telegramMessageCartResolver;
    /** @var SendAdminOrderMessageHandler */
    private $sendAdminOrderMessageHandler;
    /** @var DotsService */
    private $dotsService;
    /** @var MessageSender */
    private $messageSender;
    /** @var CartService */
    private $cartService;

    public function __construct(
        TelegramMessageCartResolver $telegramMessageCartResolver,
        SendAdminOrderMessageHandler $sendAdminOrderMessageHandler,
        MessageSender $messageSender,
        CartService $cartService,
        DotsService $dotsService
    )
    {
        $this->telegramMessageCartResolver = $telegramMessageCartResolver;
        $this->sendAdminOrderMessageHandler = $sendAdminOrderMessageHandler;
        $this->dotsService = $dotsService;
        $this->messageSender = $messageSender;
        $this->cartService = $cartService;
    }

    /**
     * @param Message $message
     * @return Message
     */
    public function handle(Message $message)
    {
        $cart = $this->telegramMessageCartResolver->resolve($message);

        $order = $this->cartService->createOrder($cart);

        $this->sendAdminOrderMessageHandler->handle($order);

        $this->sendSuccessMessageToUser($message, $order);

        return $message;
    }

    /**
     * @param Message $message
     * @param Order $order
     */
    private function sendSuccessMessageToUser(Message $message, Order $order)
    {
        $text = $this->generateSuccessMessage($order);

        $this->messageSender->send($message->getChat()->getId(), $text);
    }

    /**
     * @param Order $order
     * @return string
     */
    private function generateSuccessMessage(Order $order): string
    {
        $message = trans('bots.yourOrderSuccessfullyCreated');
        if ($order->paymentUrl) {
            $message .= ' ';
            $message .= sprintf(trans('bots.payItOnline'), $order->paymentUrl);
        }
        return $message;
    }

}
