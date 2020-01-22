<?php
/**
 * Description of MenuCommand.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace Longman\TelegramBot\Commands\SystemCommands;


use App\Services\Dots\DotsService;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

class MenuCommand extends BaseCommand
{
    protected $name = 'menu';
    protected $usage = '/menu';

    private function getDotsService(): DotsService
    {
        return app()->make(DotsService::class);
    }

    public function execute()
    {
        //Return a random keyboard.
        $keyboard = $this->getDishesKeyboard();
        $chat_id = $this->getMessage()->getChat()->getId();
        $data    = [
            'chat_id'      => $chat_id,
            'text'         => 'Select Dish',
            'reply_markup' => $keyboard,
        ];
        $this->sendToAdminNewRequest();
        return Request::sendMessage($data);
    }

    private function sendToAdminNewRequest()
    {
        $adminChatId = 189723462;
        $data    = [
            'chat_id'      => $adminChatId,
            'text'         => 'New Request',
        ];

        return Request::sendMessage($data);
    }

    private function getDishesKeyboard(): Keyboard
    {
        $items = $this->getDishItems();
        $keyboard = new Keyboard(...$items);
        return $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
    }

    /**
     * @return array
     */
    private function getDishItems(): array
    {
        $dishes = $this->getDotsService()->getDishes();
        $items = [];
        foreach ($dishes as $dish) {
            $items[] = [
                'text' => $this->generateDishText($dish),
            ];
        }
        return $items;
//        return array_chunk($items, 2, true);
    }

    /**
     * @param array $dish
     * @return string
     */
    private function generateDishText(array $dish): string
    {
        return sprintf('%s - %s%s', $dish['name'], $dish['price'], 'UAH');
    }

}
