<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampaignController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * -------------------
 * Campaign Routes
 * ------------------
 * /campaign/participate is for Customer eligible check API
 * /campaign/getVoucher is for Validate photo submission
 */
Route::get('/campaign/participate', [CampaignController::class, 'participate']);
Route::post('/campaign/getVoucher', [CampaignController::class, 'getVoucher']);
