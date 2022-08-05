<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CampaignService;
use App\Models\Customer;

class CampaignController extends Controller
{

    public function participate()
    {
        # If customer_id is not included in request, response 400 status
        if(!isset(request()->customer_id)) {

            return response()->json([
                'errors' => [
                    'message' => 'Must Include customer_id.'
                ]
            ], 400);
        }


        # If cutomer_id is not found in database, response 404 status
        if(!$customer = Customer::find(request()->customer_id)) {

            return response()->json([
                'meta' => [
                    'customer_id' => request()->customer_id,
                ],
                'errors' => [
                    'message' => "Customer with id " . request()->customer_id . " doesn't exist."
                ]
            ], 404);
        }

        # Main part of the Customer eligible check service
        $customer = Customer::find(request()->customer_id);
        $campaign = new CampaignService($customer);

        return $campaign->enterCampaign();
    }

    public function getVoucher(Request $request)
    {
        # If customer_id is not included in request, response 400 status
        if(!isset(request()->customer_id)) {

            return response()->json([
                'errors' => [
                    'message' => 'Must Include customer_id.'
                ]
            ], 400);
        }


        # If cutomer_id is not found in database, response 404 status
        if(!$customer = Customer::find(request()->customer_id)) {

            return response()->json([
                'meta' => [
                    'customer_id' => request()->customer_id,
                ],
                'errors' => [
                    'message' => "Customer with id " . request()->customer_id . " doesn't exist."
                ]
            ], 404);
        }

        # Validate file whether it is image or not
        $validator = validator(request()->all(), [
            'image' => 'required|image|mimes:jpg,png,jpeg|max:4096',
        ]);

        if($validator->fails()) {
            return response()->json([
                'meta' => [
                    'customer_id' => request()->customer_id,
                ],
                'errors'=>$validator->errors()
            ], 400);
        }
    
        $customer = Customer::find(request()->customer_id);
        $campaign = new CampaignService($customer);

        return $campaign->getVoucher();
    }


}
