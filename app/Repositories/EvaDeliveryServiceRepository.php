<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use App\Models\EvaDeliveryService;
use InfyOm\Generator\Common\BaseRepository;

/**
 *
 */
class EvaDeliveryServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        //'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EvaDeliveryService::class;
    }


}
