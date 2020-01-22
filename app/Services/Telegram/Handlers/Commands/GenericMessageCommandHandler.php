<?php
/**
 * Description of GenericMessageCommandHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Handlers\Commands;


use App\Services\Telegram\Commands\Command;
use App\Services\Telegram\Resolvers\MessageCommandResolver;
use App\Services\Telegram\Senders\NotFoundMessageSender;
use Longman\TelegramBot\Commands\SystemCommand;

class GenericMessageCommandHandler
{

    /** @var PhoneCommandHandler */
    private $phoneCommandHandler;
    /** @var OrderCommandHandler */
    private $orderCommandHandler;
    /** @var NotFoundMessageSender */
    private $notFoundMessageSender;
    /** @var MessageCommandResolver */
    private $messageCommandResolver;

    public function __construct(
        PhoneCommandHandler $phoneCommandHandler,
        OrderCommandHandler $orderCommandHandler,
        NotFoundMessageSender $notFoundMessageSender,
        MessageCommandResolver $messageCommandResolver
    )
    {
        $this->phoneCommandHandler = $phoneCommandHandler;
        $this->orderCommandHandler = $orderCommandHandler;
        $this->notFoundMessageSender = $notFoundMessageSender;
        $this->messageCommandResolver = $messageCommandResolver;
    }

    public function handle(SystemCommand $systemCommand)
    {
        $command = $this->messageCommandResolver->resolve($systemCommand->getMessage());
        switch ($command) {
            case Command::PHONE:
                return $this->phoneCommandHandler->handle($systemCommand);
            case Command::ORDER:
                return $this->orderCommandHandler->handle($systemCommand);
            default:
                return $this->notFoundMessageSender->send($systemCommand->getMessage()->getChat()->getId());
        }
    }

}
