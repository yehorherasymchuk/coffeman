<?php
/**
 * Description of DotsProvider.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Dots\Providers;


use App\Services\Http\HttpClient;

class DotsProvider extends HttpClient
{

    const MENU_URL_TEMPLATE = '/api/company/%s/dishes';
    const ORDER_URL = '/public-api/create-order';

    public function getServiceHost()
    {
        return config('services.dots.host');
    }

    public function getMenuList(): array
    {
        return $this->get($this->generateMenuUrl()) ?: [];
    }

    public function makeOrder(array $data): array
    {
        $orderData['orderFields'] = $data;
        $orderData['orderFields']['company_id'] = config('services.dots.company_id');
        return $this->post(self::ORDER_URL, $orderData, [
            'json' => true,
        ]);
    }

    private function generateMenuUrl()
    {
        return sprintf(self::MENU_URL_TEMPLATE, config('services.dots.company_id'));
    }
}
