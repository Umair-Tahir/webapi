<?php
namespace App\Http\Controllers\API;


use App\Criteria\Categories\CategoriesOfCuisinesCriteria;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GlobalPayment;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\GlobalPaymentRepository;
use App\Repositories\PaymentRepository;
use Flash;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API
 */
class GlobalPaymentAPIController extends Controller
{
    /** @var  CategoryRepository */
    private $globalPaymentRepository;
    /** @var  PaymentRepository */
    private $paymentRepository;

    public function __construct(GlobalPaymentRepository $globalPaymentRepository,PaymentRepository $paymentRepository)
    {
        $this->globalPaymentRepository = $globalPaymentRepository;
        $this->paymentRepository = $paymentRepository;
    }


    public function authorizePayment(Request $request)
    {

        $input=$request->all();

        try{
            $user=User::findOrFail($input['user_id']);
            $input['user_name']=$user->name;
            $paymentResponse=$this->globalPaymentRepository->authorizePayment($input);
            if (gettype($paymentResponse) == 'object' && $paymentResponse->responseCode == 00) {

                //On success payment save details and return payment ID
                $payment = $this->paymentRepository->create([
                    "price" => $input['grand_total'],
                    "user_id" => $input['user_id'],
                    "status" => 'success',
                    "method" => 'global_payment',
                    'response_code' => $paymentResponse->responseCode,
                    'response_message' => $paymentResponse->responseMessage,
                    'gp_order_id' => $paymentResponse->orderId,
                    'authorization_code' => $paymentResponse->authorizationCode,
                    'transaction_id' => $paymentResponse->transactionId,
                    'scheme_id' => $paymentResponse->schemeId,
                ]);

                 $response = [
                    'status' => 'Success',
                    'data' => $payment->id
                ];
            } else{
                //On transaction errors  return error message by Global Payments
                 $response = [
                    'status' => 'Failed',
                    'error' => $paymentResponse
                ];
            }
        } catch (RepositoryException $e) {
            return ($e->getMessage());
        }
        return $this->sendResponse($response, 'Transaction Results');
    }

}
