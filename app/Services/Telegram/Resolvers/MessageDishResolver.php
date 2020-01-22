<?php
/**
 * Description of MessageDishResolver.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Resolvers;


use App\Services\Dots\DotsService;
use Longman\TelegramBot\Entities\Message;

class MessageDishResolver
{
    /** @var DotsService */
    private $dotsService;

    public function __construct(
        DotsService $dotsService
    )
    {
        $this->dotsService = $dotsService;
    }

    /**
     * @param Message $message
     * @return array|null
     */
    public function resolve(Message $message): ?array
    {
        if (!$message->getText(true)) {
            return null;
        }
        return $this->dotsService->findDishByName($message->getText(true));
    }

}
