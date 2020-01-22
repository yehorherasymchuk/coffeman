<?php
/**
 * Description of RedisCartRepository.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Cart\Repositories;


use Illuminate\Support\Facades\Redis;
use App\Services\Cart\DTO\CartDTO;

class RedisCartRepository implements CartRepositoryInterface
{

    const CART_KEY_PREFIX = 'cart-key-';

    /**
     * @param string $key
     * @return ?CartDTO
     */
    public function findByKey(string $key): ?CartDTO
    {
        $data = $this->get($key);
        if (!$data) {
            return null;
        }
        return CartDTO::fromArray($data);
    }

    /**
     * @param CartDTO $cartDTO
     * @return CartDTO
     */
    public function store(CartDTO $cartDTO): CartDTO
    {
        $this->set($cartDTO->getKey(), $cartDTO->toArray());
        return $cartDTO;
    }

    /**
     * @param CartDTO $cartDTO
     */
    public function clear(CartDTO $cartDTO)
    {
        $cartDTO->clearItems();
        $this->store($cartDTO);
    }

    /**
     * @param string $key
     * @return array|null
     */
    private function get(string $key): ?array
    {
        $data = Redis::get($this->generateCartId($key));
        return json_decode($data, true);
    }

    /**
     * @param string $key
     * @param array|null $data
     */
    private function set(string $key, ?array $data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }
        Redis::set($this->generateCartId($key), $data);
    }

    /**
     * @param string $key
     * @return string
     */
    private function generateCartId(string $key): string
    {
        return md5(self::CART_KEY_PREFIX . $key);
    }
}
