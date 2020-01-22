<?php
/**
 * Description of MenuSender.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Senders;


use App\Services\Dots\DotsService;
use Longman\TelegramBot\Entities\Keyboard;

class MenuSender extends TelegramSender
{

    /** @var DotsService */
    private $dotsService;

    public function __construct(
        DotsService $dotsService
    )
    {
        $this->dotsService = $dotsService;
    }

    public function send(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text' => trans('bots.pleaseChooseYourDish'),
            'reply_markup' => $this->getDishesKeyboard()
        ];
        return $this->sendData($data);
    }

    /**
     * @return Keyboard
     */
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
        $dishes = $this->dotsService->getDishes();
        $items = [];
        foreach ($dishes as $dish) {
            $items[] = [
                'text' => $this->generateDishText($dish),
            ];
        }
        return $items;
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
