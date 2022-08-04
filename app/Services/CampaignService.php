<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Voucher;
use App\Models\PurchaseTransaction;

class CampaignService
{
   
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * ------------------------
     * function enterCampaign()
     * ------------------------
     * 
     * Step 1. Check all vouchers are fully redeemed or locked down
     * 
     * Step 2. Check eligible to get voucher with 3 criteria
     *          1.) Each customer is allowed to redeem 1 cash voucher only.
     *          2.) Complete 3 purchase transactions within the last 30 days.
     *          3.) Total transactions equal or more than $100.
     * 
     * Step 3. If everything meet okay, Lock down a voucher for that customer.
     */

    public function enterCampaign()
    {

        // Step 1
        $this->unlockLockedDownExpiredVouchers();
        
        if(!$this->checkAvailableVoucher()) {

            return response()->json([
                'meta' => [
                    'success' => false,
                ],
                'errors' => [
                    'code' => 1,
                    'message' => "Vouchers are fully redeemed or locked down.",
                ],
            ], 200);

        }
        
        // Step 2
        if($error_message = $this->checkEligibilityToParticipate()) {

            return response()->json([
                'meta' => [
                    'customer_id' => $this->customer->id,
                    'success' => false,
                ],
                'errors' => [
                    'code' => 2,
                    'message' => $error_message,
                ],
            ], 200);

        } 

        // Step 3
        $this->lockDownAVoucher();

        return response()->json([
            'meta' => [
                'customer_id' => $this->customer->id,
                'success' => true,
                'message' => "Locked down a voucher. Need to send a qualified photo within 10 minutes to redeem it.",
            ],
        ], 200);

    }

    private function unlockLockedDownExpiredVouchers()
    {
        $vouchers = Voucher::where('status', 'locked')->where('locked_down_expired_at', '<', date('Y-m-d H:i:s'))->get();
        
        foreach( $vouchers as $voucher ) {
            $voucher->customer_id = null; 
            $voucher->status = 'available';
            $voucher->locked_down_expired_at = null;
            $voucher->save();
        }
    }

    private function checkAvailableVoucher() 
    {
        $voucher = Voucher::where('status', 'available')->first();

        return $voucher ? true : false;
    }

    private function checkEligibilityToParticipate()
    {
        if(Voucher::where('customer_id', $this->customer->id)->first()) 
            return "Each customer is allowed to redeem 1 cash voucher only.";

        
        $start_date = date('Y-m-d', strtotime("-30 days"));
        $transactions = PurchaseTransaction::where('customer_id', $this->customer->id)->where('transaction_at', '>=', $start_date)->get();
        
        if( count($transactions) < 3 ) 
            return "Customer with id " . $this->customer->id . " haven't completed 3 purchase transactions within the last 30 days.";

        $total = PurchaseTransaction::where('customer_id', $this->customer->id)->where('transaction_at', '>=', $start_date)->sum('total_spent');
        if( $total < 100 )
            return "Total transactions equal or more than $100.";

        return "";
    }

    private function lockDownAVoucher()
    {
        $voucher = Voucher::where('status', 'available')->first();

        $voucher->customer_id = $this->customer->id;
        $voucher->status = 'locked';
        $voucher->locked_down_expired_at = date('Y-m-d H:i:s', strtotime("+10 minutes"));
        $voucher->save();

    }

    
    
}