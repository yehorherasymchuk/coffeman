<?php
/**
 * Description of DotsService.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Dots;


use App\Services\Dots\Providers\DotsProvider;
use App\Services\Dots\Resolvers\DishByNameResolver;

class DotsService
{

    /** @var DotsProvider */
    private $dotsProvider;
    /** @var DishByNameResolver */
    private $dishByNameResolver;

    public function __construct(
        DotsProvider $dotsProvider,
        DishByNameResolver $dishByNameResolver
    ) {
        $this->dotsProvider = $dotsProvider;
        $this->dishByNameResolver = $dishByNameResolver;
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function findDishByName(string $name): ?array
    {
        return $this->dishByNameResolver->resolve($name);
    }

    /**
     * @return array
     */
    public function getDishes(): array
    {
        return $this->dotsProvider->getMenuList();
    }

    /**
     * @param array $data
     * @return array
     */
    public function makeOrder(array $data): array
    {
        return $this->dotsProvider->makeOrder($data);
    }

}
