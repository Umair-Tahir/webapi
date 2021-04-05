<?php

namespace App\Http\Controllers;

use App\DataTables\DeliveryTypeDataTable;
use App\Http\Requests\CreateDeliveryTypeRequest;
use App\Http\Requests\UpdateDeliveryTypeRequest;
use App\Repositories\DeliveryTypeRepository;
use Flash;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class DeliveryTypeController extends Controller
{
    /** @var  DeliveryTypeRepository */
    private $deliveryTypeRepository;

    public function __construct(DeliveryTypeRepository $deliveryTypeRepo)
    {
        parent::__construct();
        $this->deliveryTypeRepository = $deliveryTypeRepo;
    }

    /**
     * Display a listing of the DeliveryType.
     *
     * @param DeliveryTypeDataTable $deliveryTypeDataTable
     * @return Response
     */
    public function index(DeliveryTypeDataTable $deliveryTypeDataTable)
    {
        return $deliveryTypeDataTable->render('delivery_types.index');
    }

    /**
     * Show the form for creating a new DeliveryType.
     *
     * @return Response
     */
    public function create()
    {
        return view('delivery_types.create');
    }

    /**
     * Store a newly created DeliveryType in storage.
     *
     * @param CreateDeliveryTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateDeliveryTypeRequest $request)
    {
        $input = $request->all();
        try {
            $deliveryType = $this->deliveryTypeRepository->create($input);
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.DeliveryType')]));

        return redirect(route('deliveryTypes.index'));
    }

    /**
     * Display the specified DeliveryType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $deliveryType = $this->deliveryTypeRepository->findWithoutFail($id);

        if (empty($deliveryType)) {
            Flash::error('DeliveryType not found');

            return redirect(route('deliveryTypes.index'));
        }

        return view('delivery_types.show')->with('DeliveryType', $deliveryType);
    }

    /**
     * Show the form for editing the specified DeliveryType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $deliveryType = $this->deliveryTypeRepository->findWithoutFail($id);

        if (empty($deliveryType)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.DeliveryType')]));

            return redirect(route('deliveryTypes.index'));
        }


        return view('delivery_types.edit')->with('DeliveryType', $deliveryType);
    }

    /**
     * Update the specified DeliveryType in storage.
     *
     * @param int $id
     * @param UpdateDeliveryTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeliveryTypeRequest $request)
    {
        $deliveryType = $this->deliveryTypeRepository->findWithoutFail($id);

        if (empty($deliveryType)) {
            Flash::error('DeliveryType not found');
            return redirect(route('deliveryTypes.index'));
        }
        $input = $request->all();
        try {
            $deliveryType = $this->deliveryTypeRepository->update($input, $id);
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.DeliveryType')]));

        return redirect(route('deliveryTypes.index'));
    }

    /**
     * Remove the specified DeliveryType from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $deliveryType = $this->deliveryTypeRepository->findWithoutFail($id);

        if (empty($deliveryType)) {
            Flash::error('DeliveryType not found');

            return redirect(route('deliveryTypes.index'));
        }

        $this->deliveryTypeRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.DeliveryType')]));

        return redirect(route('deliveryTypes.index'));
    }

}
