<?php
/**
 * Description of OrderDTO.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Dots\DTO;


class OrderDTO
{

    const DELIVERY_TO_HOUSE = 0;
    const DELIVERY_TO_FLAT = 1;
    const DELIVERY_PICKUP = 2;
    const DELIVERY_PRE_ORDER = 3;

    const PAYMENT_CASH = 1;
    const PAYMENT_ONLINE = 2;
    const PAYMENT_TERMINAL = 3;

    const TYPE_ORDERED_ONLINE = 1;
    const TYPE_ORDERED_BY_OPERATOR = 2;
    const TYPE_ORDERED_BY_COMPANY = 3;
    const TYPE_ORDERED_BY_IOS_APP = 4;
    const TYPE_ORDERED_BY_ANDROID_APP = 5;
    const TYPE_ORDERED_BY_API = 6;

}
