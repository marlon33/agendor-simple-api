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
    $me = sendApi($token, "users/me");
    return response()->json($me);
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
    return response()->json(sendApi($token, "organizations/$organizationId/deals", "post", $post));
});

Route::get('/organizations/{token}', function (Request $request, $token) {
    return response()->json(sendApi($token, "organizations?per_page=100&name=ALLBOX"));
});

Route::get('/funnels/{token}', function (Request $request, $token) {
    return response()->json(sendApi($token, "funnels"));
});

Route::get('/peopleDeals/{dealId}/{token}', function (Request $request, $dealId, $token) {
    return response()->json(sendApi($token, "people/$dealId/deals"));
});
