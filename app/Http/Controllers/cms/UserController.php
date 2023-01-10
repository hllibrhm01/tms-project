<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\cms\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\tms\TMSCustomer;
use App\Models\tms\TMSVehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Exception\RequestException;

class UserController extends Controller
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
            $req =   Request::create(
                url('oauth/token'),
                'POST',
                $loginData
            );

            $oAuthResponseData = app()->handle($req);
            $oAuthResponse = json_decode($oAuthResponseData->getContent(), true);

            return [
                "id" => $user->id,
                "name" => $user->name,
                "surname" => $user->surname,
                "email" => $user->email,
                "accessToken" =>  $oAuthResponse['access_token'],
                'refreshToken' => $oAuthResponse['refresh_token'],
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'permissions_hashed' => sha1(json_encode($user->getAllPermissions()->pluck('name')->toArray())),
                "role" => $user->getRoleNames()->first(),
            ];
        } catch (RequestException $e) {
        }
    }

    public function index()
    {
        // $users = User::all();
        $users = User::getAllRoleByUserJoin();
        foreach ($users as $user) {
            $user->role = $user->roles->first();
        }
        return view('cms.user.index', compact('users'));
    }


    public function add()
    {
        $roles = Role::getAllRoles();
        $permissions = Permission::getAllPermissions();
        $tms_vehicles = TMSVehicle::all();
        $tms_customers = TMSCustomer::all();
        return view('cms.user.add', compact("permissions", "roles", "tms_vehicles", "tms_customers"));
    }

    public function store(UserRequest $request)
    {
        $user = User::addUser(strtoupper($request->name), strtolower($request->email), $request->password, $request->vehicle_id , $request->tms_id);
        if (is_null($user))
            return Redirect::route('get.cms.user.index');

        $user->syncRoles($request->role_id);
        $user->syncPermissions($request->permissions);
        return Redirect::route('get.cms.user.index');
    }

    public function edit($id)
    {
        $roles = Role::getAllRoles();
        $permissions = Permission::getAllPermissions();
        $user = User::find($id);
        $userRole = $user->roles->first();
        $userPermissions = $user->permissions;
        $tms_vehicles = TMSVehicle::all();
        $tms_customers = TMSCustomer::all();
        return view('cms.user.edit', compact('user', 'userRole', 'userPermissions', "permissions", "roles", "tms_vehicles", "tms_customers"));
    }

    public function view($id)
    {
        $roles = Role::getAllRoles();
        $permissions = Permission::getAllPermissions();
        $user = User::find($id);
        $userRole = $user->roles->first();
        $userPermissions = $user->permissions;
        $tms_vehicles = TMSVehicle::all();
        $tms_customers = TMSCustomer::all();
        return view('cms.user.view', compact('user', 'userRole', 'userPermissions', "permissions", "roles", "tms_vehicles", "tms_customers"));
    }


    public function update(UserRequest $request, $id)
    {
        $user = User::editUser($id, strtoupper($request->name), strtolower($request->email), $request->vehicle_id, $request->tms_id);
        if (is_null($user))
            return Redirect::route('get.cms.user.index');

        $user->syncRoles($request->role_id);
        $user->syncPermissions($request->permissions);
        return Redirect::route('get.cms.user.index');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!is_null($user))
            $user->delete();

        return Redirect::route('get.cms.user.index');
    }

}
