<?php
/**
 * Description of UserDataGenerator.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Generators;


use Longman\TelegramBot\Entities\Message;

class UserDataGenerator
{

    /**
     * @param Message $message
     * @return array
     */
    public function fromMessage(Message $message): array
    {
        return [
            'telegram_id' => $this->getTelegramId($message),
            'name' => $this->generateUserName($message),
            'phone' => $this->getUserPhone($message),
            'lang' => $this->getUserLang($message),
        ];
    }

    /**
     * @param Message $message
     * @return int
     */
    private function getTelegramId(Message $message): int
    {
        return $message->getChat()->getId();
    }

    /**
     * @param Message $message
     * @return string
     */
    private function generateUserName(Message $message): string
    {
        return $message->getFrom()->getFirstName() . ' ' . $message->getFrom()->getLastName();
    }

    /**
     * @param Message $message
     * @return string|null
     */
    private function getUserPhone(Message $message): ?string
    {
        if (!$message->getContact()) {
            return null;
        }
        return $message->getContact()->getPhoneNumber();
    }

    /**
     * @param Message $message
     * @return string|null
     */
    private function getUserLang(Message $message): ?string
    {
        return $message->getFrom()->getLanguageCode();
    }

}
