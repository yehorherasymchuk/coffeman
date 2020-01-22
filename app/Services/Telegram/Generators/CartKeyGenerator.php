<?php
/**
 * Description of CartKeyGenerator.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Generators;


use Longman\TelegramBot\Entities\Message;

class CartKeyGenerator
{

    /**
     * @param Message $message
     * @return string
     */
    public function generate(Message $message): string
    {
        return md5($message->getChat()->getId());
    }

}
