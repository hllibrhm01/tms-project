<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\PermissionRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\Redirect;

class PermissionController  extends Controller
{


    public function index()
    {
        $permissions = Permission::getAllPermissions();
        return view('cms.permission.index', compact('permissions'));
    }

    public function add()
    {
        return view('cms.permission.add');
    }

    public function store(PermissionRequest $request)
    {
        Permission::addPermission($request->name , $request->guard_name);
        return Redirect::route('get.cms.permission.index');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('cms.permission.edit', compact('permission'));
    }

    public function update($id, PermissionRequest $request)
    {
        Permission::editPermission($id, $request->name, $request->guard_name);
        return Redirect::route('get.cms.permission.index');
    }

    public function destroy($id)
    {
        Permission::deletePermission($id);
        return Redirect::route('get.cms.permission.index');
    }
}
