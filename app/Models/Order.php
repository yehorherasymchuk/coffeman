<?php
/**
 * Description of Order.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 * @property int $id
 * @property array $items
 * @property array $location
 * @property string $userName
 * @property string $userPhone
 * @property string $paymentUrl
 *
 * @property User $user
 */
class Order extends Model
{

    protected $casts = [
        'items' => 'array',
        'location' => 'array',
    ];

    protected $fillable = [
        'items',
        'user_id',
        'location',
        'address',
        'userName',
        'userPhone',
        'paymentUrl',
    ];

}
