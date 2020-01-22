<?php
/**
 * Description of StartCommandHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Handlers\Commands;


use App\Services\Telegram\Handlers\CreateTelegramUserHandler;
use App\Services\Telegram\Senders\MenuSender;
use App\Services\Telegram\Senders\RequestPhoneSender;
use Longman\TelegramBot\Commands\SystemCommand;

class StartCommandHandler
{
    /** @var CreateTelegramUserHandler */
    private $createTelegramUserHandler;
    /** @var RequestPhoneSender */
    private $requestPhoneSender;
    /** @var MenuSender */
    private $menuSender;

    public function __construct(
        CreateTelegramUserHandler $createTelegramUserHandler,
        RequestPhoneSender $requestPhoneSender,
        MenuSender $menuSender
    )
    {
        $this->createTelegramUserHandler = $createTelegramUserHandler;
        $this->requestPhoneSender = $requestPhoneSender;
        $this->menuSender = $menuSender;
    }

    public function handle(SystemCommand $systemCommand)
    {
        $user = $this->createTelegramUserHandler->handle($systemCommand->getMessage());
        if (!$user->phone) {
            return $this->requestPhoneSender->send($user->telegram_id);
        }
        return $this->menuSender->send($user->telegram_id);
    }

}
