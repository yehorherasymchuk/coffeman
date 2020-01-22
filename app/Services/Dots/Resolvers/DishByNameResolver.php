<?php
/**
 * Description of DishByNameResolver.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Dots\Resolvers;


use App\Services\Dots\Providers\DotsProvider;

class DishByNameResolver
{
    /** @var DotsProvider */
    private $dotsProvider;

    public function __construct(
        DotsProvider $dotsProvider
    )
    {
        $this->dotsProvider = $dotsProvider;
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function resolve(string $name): ?array
    {
        $dishes = $this->dotsProvider->getMenuList();
        $dishes = $this->sortByNameLength($dishes);
        foreach ($dishes as $dish) {
            if (mb_strpos($name, $dish['name']) !== false) {
                return $dish;
            }
        }
        return null;
    }

    /**
     * @param array $dishes
     * @return array
     */
    private function sortByNameLength(array $dishes): array
    {
        usort($dishes, function ($a, $b) {
            if (mb_strlen($a['name']) === mb_strlen($b['name'])) {
                return 0;
            }
            return mb_strlen($a['name']) < mb_strlen($b['name']) ? 1 : -1;
        });
        return $dishes;
    }

}
