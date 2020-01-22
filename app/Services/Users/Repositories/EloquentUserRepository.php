<?php
/**
 * Description of EloquentUserRepository.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Users\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function findByTelegramId(int $telegramUserId): ?User
    {
        return User::where('telegram_id', $telegramUserId)
            ->first();
    }

    public function getTelegramAdmins(): Collection
    {
        return User::whereNotNull('telegram_id')
            ->where('level', User::LEVEL_ADMIN)
            ->get();
    }

    /**
     * @param array $data
     * @return User
     */
    public function createFromArray(array $data): User
    {
        return User::create($data);
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateFromArray(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
}
