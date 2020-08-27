<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ItemPaymentController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type_model, $model_id)
    {
        $model = $this->getTypeModel($type_model, $model_id);
        $payments = $model->payments;
        return PaymentResource::collection($payments);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request, $type_model, $model_id)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $model = $this->getTypeModel($type_model, $model_id);
        $payment = $model->payments()->create($data);
        DB::commit();
        return new PaymentResource($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function destroy($type_model, $model_id, $payment_id)
    {
        DB::beginTransaction();
        $model = $this->getTypeModel($type_model, $model_id);
        $payment = $model->payments()->findOrFail($payment_id);
        $payment->delete();
        DB::commit();
        return new PaymentResource($payment);
    }

    private function getTypeModel($type, $model_id)
    {
        $types = [
            'permit' => "App\Models\Permits",
            'guest' => "App\Models\Guests",
        ];

        abort_unless(isset($types[$type]), Response::HTTP_UNPROCESSABLE_ENTITY, "Invalid Model Type. Options allowed:permit,guest,group,joint. Received:{$type}");

        $class = $types[$type];
        return $class::findOrFail($model_id);
    }
}
