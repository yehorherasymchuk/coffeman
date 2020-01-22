<?php
/**
 * Description of CartItemDTO.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Cart\DTO;


class CartItemDTO
{

    /** @var int */
    private $dish_id;
    /** @var string */
    private $name;
    /** @var float */
    private $price;
    /** @var int */
    private $count;

    private function __construct(
        $dish_id,
        $name,
        $price,
        $count
    )
    {
        $this->dish_id = $dish_id;
        $this->name = $name;
        $this->price = $price;
        $this->count = $count;
    }

    public static function fromArray(array $data)
    {
        return new self(
            $data['dish_id'],
            $data['name'],
            $data['price'] ?? 0,
            $data['count'] ?? 1
        );
    }

    public function toArray(): array
    {
        return [
            'dish_id' => $this->getDishId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'count' => $this->getCount(),
        ];
    }

    /**
     * @return int
     */
    public function getDishId(): int
    {
        return $this->dish_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

}
