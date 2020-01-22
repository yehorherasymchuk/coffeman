<?php
/**
 * Description of OrderRepositoryInterface.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Orders\Repositories;


use App\Models\Order;

interface OrderRepositoryInterface
{

    public function find(int $id): ?Order;
    public function createFromArray(array $data): Order;

}
