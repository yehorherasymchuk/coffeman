<?php
/**
 * Description of CreateTelegramUserHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Telegram\Handlers;


use App\Models\User;
use App\Services\Telegram\Generators\UserDataGenerator;
use App\Services\Users\UsersService;
use Longman\TelegramBot\Entities\Message;

class CreateTelegramUserHandler
{

    /** @var UsersService */
    private $usersService;
    /** @var UserDataGenerator */
    private $userDataGenerator;

    public function __construct(
        UsersService $usersService,
        UserDataGenerator $userDataGenerator
    ) {
        $this->usersService = $usersService;
        $this->userDataGenerator = $userDataGenerator;
    }

    public function handle(Message $message): User
    {
        $telegramUserId = $message->getChat()->getId();
        $user = $this->usersService->findUserByTelegramId($telegramUserId);
        if ($user) {
            if ($message->getContact()) {
                $this->usersService->updateUser($user, [
                    'phone' => $message->getContact()->getPhoneNumber(),
                ]);
            }
            return $user;
        }
        $data = $this->userDataGenerator->fromMessage($message);
        return $this->usersService->createUser($data);
    }

}
