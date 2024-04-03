<?php

use App\Http\Agendor\AgendorAPi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

function sendApi($token, $route, $method = "get", $post = null)
{
    switch ($method) {
        case 'get':
            $agendorAPi = new AgendorAPi($token, $route);
            $response = $agendorAPi->get();
            return $response;
            break;
        case 'post':
            $agendorAPi = new AgendorAPi($token, $route);
            $response = $agendorAPi->post($post);
            return $response;
            break;
    }
}

Route::get('/me/{token}', function (Request $request,$token) {
    // return response()->json(sendApi($token, "organizations/36721930/deals", "post"));
    $me = sendApi($token, "users/me");
    $funnels = sendApi($token, "funnels");
    $organizations = sendApi($token, "organizations");
    $peopleDeals = sendApi($token, "people/820262/deals");
    $deals = sendApi($token, "deals");

    return response()->json(
        $me,
        // $funnels,
        // $organizations,
        // $peopleDeals,
        // $deals
    );
});

Route::post('/organizations/{organizationId}/{token}', function (Request $request, $organizationId, $token) {
    $post = [
        "title"=>$request->title,
        "dealStatusText"=>$request->dealStatusText,
        "ownerUser"=>$request->ownerUser,
        "funnel"=>$request->funnel,
        "dealStage"=>$request->dealStage,
        "value"=>$request->value,
        "allowToAllUsers"=>$request->allowToAllUsers
        ];
    // return response()->json($post);
    return response()->json(sendApi($token, "organizations/$organizationId/deals", "post", $post));
});

Route::get('/organizations/{token}', function (Request $request, $token) {
    return response()->json(sendApi($token, "organizations"));
});

Route::get('/funnels/{token}', function (Request $request, $dealId, $token) {
    return response()->json(sendApi($token, "funnels"));
});

Route::get('/peopleDeals/{dealId}/{token}', function (Request $request, $dealId, $token) {
    return response()->json(sendApi($token, "people/$dealId/deals"));
});
