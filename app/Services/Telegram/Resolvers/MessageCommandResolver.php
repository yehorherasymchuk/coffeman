<?php
/**
 * Description of MessageCommandResolver.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Resolvers;


use App\Services\Telegram\Commands\Command;
use Longman\TelegramBot\Entities\Message;

class MessageCommandResolver
{

    /** @var MessageDishResolver */
    private $messageDishResolver;

    public function __construct(
        MessageDishResolver $messageDishResolver
    )
    {
        $this->messageDishResolver = $messageDishResolver;
    }

    /**
     * @param Message $message
     * @return string|null
     */
    public function resolve(Message $message): ?string
    {
        if ($this->isCommandContactSharing($message)) {
            return Command::PHONE;
        } elseif ($this->isCommandLocationSharing($message)) {
            return Command::LOCATION;
        } elseif ($this->isCommandAddDish($message)) {
            return Command::ORDER;
        }
        return null;
    }

    /**
     * @param Message $message
     * @return bool
     */
    private function isCommandContactSharing(Message $message): bool
    {
        if ($message->getContact() && $message->getContact()->getPhoneNumber()) {
            return true;
        }
        return $this->isTextPhoneNumber($message->getText(true) ?: '');
    }

    /**
     * @param string $phone
     * @return bool
     */
    private function isTextPhoneNumber(string $phone): bool
    {
        return is_numeric($phone);
    }

    /**
     * @param Message $message
     * @return bool
     */
    private function isCommandLocationSharing(Message $message): bool
    {
        return $message->getLocation() && $message->getLocation()->getLatitude();
    }

    /**
     * @param Message $message
     * @return bool
     */
    private function isCommandAddDish(Message $message): bool
    {
        return !empty($this->messageDishResolver->resolve($message));
    }

}
