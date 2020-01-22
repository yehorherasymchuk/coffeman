<?php
/**
 * Description of CartRepositoryInterface.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Cart\Repositories;


use App\Services\Cart\DTO\CartDTO;

interface CartRepositoryInterface
{

    public function findByKey(string $key): ?CartDTO;

    public function store(CartDTO $cartDTO): CartDTO;

    public function clear(CartDTO $cartDTO);

}
