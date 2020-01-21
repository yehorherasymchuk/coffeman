<?php
/**
 * Description of StartCommand.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace Longman\TelegramBot\Commands\SystemCommands;


use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

class StartCommand extends SystemCommand
{
    protected $name = 'start';
    protected $usage = '/start';

    public function execute()
    {
        $message = $this->getMessage();
        $keyboard = (new Keyboard([
            ['text' => 'Send my contact', 'request_contact' => true],
        ]))
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);

        $chat_id = $message->getChat()->getId();
        $text = 'Hi! ' . $message->getChat()->getFirstName() . ' ' . $message->getChat()->getLastName();

        $text .= ' Please give us your number!';
        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $keyboard
        ];
        return Request::sendMessage($data);
    }
}
