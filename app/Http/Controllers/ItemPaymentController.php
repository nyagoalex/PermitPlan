<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\ItemPayment;
use App\Models\Setting;
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

        $amount = $data['amount'];
        if($type_model == 'permit') {
            abort_if($amount > $model->balance, Response::HTTP_BAD_REQUEST, "Action Failed, Permit Over Payment Amount:{$amount} Bal:{$model->balance}");

            if($model->paid > 0) {
                abort_unless($amount == $model->balance, Response::HTTP_BAD_REQUEST, "Action Failed, Full Payment Of Balance {$model->balance} Only Allowed For Second Payment");
            }
            if(!in_array($amount, [$model->cost, round($model->cost * 0.3, 2), round($model->cost * 0.7, 2)])) {
                abort(Response::HTTP_BAD_REQUEST, "Action Failed, Full Balance, 30% or 70% Payment Allowed");
            }
            $settings = Setting::first();
            $model->expired_date = today()->addDays($settings->permit_expiry_in_days)->format('Y-m-d');
            $model->save();
        }

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
    public function destroy($payment_id)
    {
        DB::beginTransaction();
        $payment = ItemPayment::findOrFail($payment_id);
        $payment->delete();
        DB::commit();
        return new PaymentResource($payment);
    }

    private function getTypeModel($type, $model_id)
    {
        $types = [
            'permit' => "App\Models\Permit",
            'guest' => "App\Models\Guest",
        ];

        abort_unless(isset($types[$type]), Response::HTTP_UNPROCESSABLE_ENTITY, "Invalid Model Type. Options allowed:permit,guest,group,joint. Received:{$type}");

        $class = $types[$type];
        return $class::findOrFail($model_id);
    }
}
