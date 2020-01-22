<?php
/**
 * Description of CartUserDTO.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Cart\DTO;


use App\Models\User;

class CartUserDTO
{

    private $id;
    private $name;
    private $phone;

    private function __construct(
        ?int $id,
        string $name,
        ?string $phone
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
    }

    public static function fromUser(User $user)
    {
        return self::fromArray([
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
        ]);
    }

    public static function fromArray(array $data)
    {
        return new self(
            $data['id'] ?? null,
            $data['name'] ?? '',
            $data['phone'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
        ];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

}
