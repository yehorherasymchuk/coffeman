<?php
/**
 * Description of SendMessageHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Handlers;


use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class SendMessageHandler
{

    /**
     * @param int $chatId
     * @param string $message
     */
    public function handle(int $chatId, string $message)
    {
        try {
            $data = [
                'chat_id' => $chatId,
                'text'    => $message,
            ];

            Request::sendMessage($data);
        } catch (TelegramException $e) {
            \Log::warning($e->getMessage(), $data);
        }

    }

}
