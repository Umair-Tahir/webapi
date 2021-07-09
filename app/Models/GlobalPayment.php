<?php

namespace App\Models;

use CraigPaul\Moneris\Moneris;
use App\Mail\OrderNotificationEmail;
use GlobalPayments\Api\Entities\Exceptions\ApiException;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\ServiceConfigs\Gateways\GpEcomConfig;
use GlobalPayments\Api\ServicesContainer;
use Illuminate\Support\Facades\Mail;

use Illuminate\Database\Eloquent\Model;

class GlobalPayment extends Model
{

    public function authorizePayment($data)
    {
        if(getenv('Live_GP')=== "true"){
            $clientId=getenv('GP_CLIENT_ID');
            $accountId=getenv('GP_ACCOUNT_ID');
            $secret=getenv('GP_SECRET');
            $url=getenv('GP_URL');

        }else{
            $clientId=getenv('SANDBOX_GP_CLIENT_ID');
            $accountId=getenv('SANDBOX_GP_ACCOUNT_ID');
            $secret=getenv('SANDBOX_GP_SECRET');
            $url=getenv('SANDBOX_GP_URL');
        }

        $config = new GpEcomConfig();
        $config->merchantId = $clientId;
        $config->accountId = $accountId;
        $config->sharedSecret = $secret;
        $config->serviceUrl = $url;
        ServicesContainer::configureService($config);

// create the card object
        $card = new CreditCardData();
        $card->number = $data['credit_card'];
        $card->expMonth = $data['expiry_month'];
        $card->expYear = $data['expiry_year'];
        $card->cvn = $data['cvc_code'];
        $card->cardHolderName =$data['card_holder_name'];

        try {
            // process an auto-capture authorization
            $response = $card->charge($data['grand_total'])
                ->withCurrency("CAD")
                ->execute();
        } catch (ApiException $e) {
            return $e->getMessage();
        }

        if (isset($response)) {
            return $response;
//            $result = $response->responseCode; // 00 == Success
//            $message = $response->responseMessage; // [ test system ] AUTHORISED
//
//            // get the details to save to the DB for future requests
//            $orderId = $response->orderId; // N6qsk4kYRZihmPrTXWYS6g
//            $authCode = $response->authorizationCode; // 12345
//            $paymentsReference = $response->transactionId; // pasref: 14610544313177922
//            $schemeReferenceData = $response->schemeId; // MMC0F00YE4000000715
        }
    }



}
