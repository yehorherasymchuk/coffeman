<?php
/**
 * Description of CreateUserHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Users\Handlers;


use App\Models\User;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Hash;
use Str;

class CreateUserHandler
{

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return User
     */
    public function handle(array $data): User
    {
        if (!isset($data['password'])) {
            $data['password'] = Str::random(32);
        }

        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createFromArray($data);
    }
}
