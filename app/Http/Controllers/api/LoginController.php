<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use App\Models\User;
use App\Models\tms\TMSVehicle;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::getByEmail($request->email);
        $loginData = [
            "grant_type" => "password",
            "client_id" => env('OUATH2_CLIENT_ID'),
            "client_secret" => env('OUATH2_CLIENT_SECRET'),
            "username" => $request->email,
            "password" => $request->password,
            "scope" => "*"
        ];

        try {
            $req = Request::create(
                url('oauth/token'),
                'POST',
                $loginData
            );

            $oAuthResponseData = app()->handle($req);
            $oAuthResponse = json_decode($oAuthResponseData->getContent(), true);
            
            $vehicle = TMSVehicle::getVehicleId($user->id);

            if ($vehicle != null) {
                return [
                    "id" => $user->id,
                    "name" => $user->name,
                    "surname" => $user->surname,
                    "vehicle_id" => $user->vehicle_id,
                    "tms_id" => $user->tms_id,
                    "email" => $user->email,
                    "vehicleId" =>$vehicle->id == null ? 0 : $vehicle->id,
                    "accessToken" =>  $oAuthResponse['access_token'],
                    'refreshToken' => $oAuthResponse['refresh_token'],
                    'permissions' => $user->getAllPermissions()->pluck('name'),
                    'permissions_hashed' => sha1(json_encode($user->getAllPermissions()->pluck('name')->toArray())),
                    "role" => $user->getRoleNames()->first(),
                ];
            } else {
                return [
                    "id" => $user->id,
                    "name" => $user->name,
                    "surname" => $user->surname,
                    "vehicle_id" => $user->vehicle_id,
                    "tms_id" => $user->tms_id,
                    "email" => $user->email,
                    "accessToken" =>  $oAuthResponse['access_token'],
                    'refreshToken' => $oAuthResponse['refresh_token'],
                    'permissions' => $user->getAllPermissions()->pluck('name'),
                    'permissions_hashed' => sha1(json_encode($user->getAllPermissions()->pluck('name')->toArray())),
                    "role" => $user->getRoleNames()->first(),
                ];
            }

        } catch (RequestException $e) {}
    }

    public function logout(Request $request) {
        // $token = $request->accessToken;
        // $user = Auth::user()->tokens()->revoke();
        // $token = Auth::user()->token();
        // $token->revoke();
        // $user->revoke();
        $token = $request->accessToken;
        $user = Auth::user()->token();
        // $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success' => 'Logged out successfully'], 200);
    } 
}
