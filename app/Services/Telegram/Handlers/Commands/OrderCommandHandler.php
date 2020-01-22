<?php
/**
 * Description of OrderCommandHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Handlers\Commands;


use App\Services\Telegram\Handlers\AddCartItemHandler;
use App\Services\Telegram\Handlers\CreateTelegramOrderHandler;
use App\Services\Telegram\Resolvers\MessageDishResolver;
use App\Services\Telegram\Senders\MessageSender;
use App\Services\Users\UsersService;
use Longman\TelegramBot\Commands\SystemCommand;

class OrderCommandHandler
{

    /** @var AddCartItemHandler */
    private $addCartItemHandler;
    /** @var MessageDishResolver */
    private $messageDishResolver;
    /** @var CreateTelegramOrderHandler */
    private $createTelegramOrderHandler;

    public function __construct(
        AddCartItemHandler $addCartItemHandler,
        MessageDishResolver $messageDishResolver,
        CreateTelegramOrderHandler $createTelegramOrderHandler
    )
    {
        $this->addCartItemHandler = $addCartItemHandler;
        $this->messageDishResolver = $messageDishResolver;
        $this->createTelegramOrderHandler = $createTelegramOrderHandler;
    }

    public function handle(SystemCommand $systemCommand)
    {
        $dish = $this->messageDishResolver->resolve($systemCommand->getMessage());
        $this->addCartItemHandler->handle($systemCommand->getMessage(), $dish);

        return $this->createTelegramOrderHandler->handle($systemCommand->getMessage());
    }

}
