<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Role;


class MobileUserController extends Controller
{
    public static function getRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}