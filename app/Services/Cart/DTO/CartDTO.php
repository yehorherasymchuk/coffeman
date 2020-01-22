<?php
/**
 * Description of CartDTO.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Cart\DTO;


class CartDTO
{

    private $key;
    private $items = [];
    private $user;

    private function __construct(
        string $key,
        array $items,
        CartUserDTO $user
    ) {
        $this->key = $key;
        $this->items = $items;
        $this->user = $user;
    }

    public static function fromArray(array $data): CartDTO
    {
        $items = $data['items'] ?? [];
        return new self(
            $data['key'],
            array_map(function (array $item) {
                return CartItemDTO::fromArray($item);
            }, $items),
            CartUserDTO::fromArray($data['user'] ?? [])
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'key' => $this->getKey(),
            'items' => $this->getItemsArray(),
            'user' => $this->getUser()->toArray(),
        ];
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public function getItemsArray(): array
    {
        return array_map(function (CartItemDTO $cartItemDTO) {
            return $cartItemDTO->toArray();
        }, $this->getItems());
    }

    /**
     * @return CartItemDTO[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function clearItems()
    {
        $this->items = [];
    }

    /**
     * @return CartUserDTO
     */
    public function getUser(): CartUserDTO
    {
        return $this->user;
    }

    /**
     * @param array $data
     */
    public function addItem(array $data)
    {
        $this->items[] = CartItemDTO::fromArray($data);
    }

}
