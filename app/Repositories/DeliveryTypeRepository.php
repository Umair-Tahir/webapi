<?php

namespace App\Repositories;

use App\Models\DeliveryType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DeliveryTypeRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method DeliveryType findWithoutFail($id, $columns = ['*'])
 * @method DeliveryType find($id, $columns = ['*'])
 * @method DeliveryType first($columns = ['*'])
*/
class DeliveryTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $DeliveryTypeSearchable = [
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DeliveryType::class;
    }
}
