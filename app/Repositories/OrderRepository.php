<?php

namespace App\Repositories;

use App\Models\Order;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderRepository
 * @package App\Repositories
 * @version August 31, 2019, 11:11 am UTC
 *
 * @method Order findWithoutFail($id, $columns = ['*'])
 * @method Order find($id, $columns = ['*'])
 * @method Order first($columns = ['*'])
*/
class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'order_status_id',
        'tax',
        'hint',
        'payment_id',
        'delivery_type_id',
        'delivery_address_id',
        'restaurant_id',
        'active',
        'expected_delivery_time',
        'vendor_shared_price',
        'eezly_shared_price',
        'grand_total',
        'is_french',
        'tip',
        'delivery_company_name',
        'coupon_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }
}
