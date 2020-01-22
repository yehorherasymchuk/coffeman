<?php
/**
 * Description of TelegramSender.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Senders;


use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class TelegramSender
{

    /**
     * @param array $data
     * @return ServerResponse|null
     */
    protected function sendData(array $data): ?ServerResponse
    {
        try {
            return Request::sendMessage($data);
        } catch (TelegramException $e) {
            \Log::warning($e->getMessage(), $data);
        }
        return null;
    }

}
