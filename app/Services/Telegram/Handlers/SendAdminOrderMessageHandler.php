<?php
/**
 * Description of SendAdminOrderMessageHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Handlers;


use App\Models\Order;
use App\Models\User;
use App\Services\Telegram\Generators\OrderMessageGenerator;
use App\Services\Users\UsersService;
use Illuminate\Database\Eloquent\Collection;

class SendAdminOrderMessageHandler
{

    /** @var OrderMessageGenerator */
    private $orderMessageGenerator;
    /** @var UsersService */
    private $usersService;
    /** @var SendMessageHandler */
    private $sendMessageHandler;

    public function __construct(
        OrderMessageGenerator $orderMessageGenerator,
        UsersService $usersService,
        SendMessageHandler $sendMessageHandler
    )
    {
        $this->orderMessageGenerator = $orderMessageGenerator;
        $this->usersService = $usersService;
        $this->sendMessageHandler = $sendMessageHandler;
    }

    public function handle(Order $order)
    {
        $users = $this->getUsersToNotify();
        $message = $this->orderMessageGenerator->generate($order);
        foreach ($users as $user) {
            $this->sendMessageToUser($user, $message);
        }
    }

    /**
     * @return Collection
     */
    private function getUsersToNotify(): Collection
    {
        return $this->usersService->getTelegramAdmins();
    }

    /**
     * @param User $user
     * @param string $message
     */
    private function sendMessageToUser(User $user, string $message)
    {
        $this->sendMessageHandler->handle($user->telegram_id, $message);
    }


}
