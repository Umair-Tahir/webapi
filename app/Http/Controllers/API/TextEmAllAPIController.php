<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\TextEmAll;

class TextEmAllAPIController extends Controller
{
    public function __construct()
    {
        //  $text_model = new TextEmAll();
    }

    public function sample22()
    {
        $text_model = new TextEmAll();
        $text_model = $text_model->createBroadcast();
        return $this->sendResponse($text_model, 'Success');
    }
}
