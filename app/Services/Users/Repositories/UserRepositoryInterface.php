<?php
/**
 * Description of UserRepositoryInterface.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Users\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{

    public function find(int $id): ?User;

    public function findByTelegramId(int $telegramUserId): ?User;

    public function getTelegramAdmins(): Collection;

    public function createFromArray(array $data): User;

    public function updateFromArray(User $user, array $data): User;

}
