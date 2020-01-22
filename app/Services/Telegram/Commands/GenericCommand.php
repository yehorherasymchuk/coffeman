<?php
/**
 * Description of StartCommand.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace Longman\TelegramBot\Commands\SystemCommands;


use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

class GenericCommand extends BaseCommand
{
    protected $name = 'generic';

    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $text    = 'Hi! Phone';

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
            'reply_markup' => Keyboard::remove(),
        ];
        \Log::info('Test', [$message->toJson()]);
        return Request::sendMessage($data);
    }
}
