<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\cms\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::getAllRoles();
        return view('cms.role.index', compact('roles'));
    }

    public function add()
    {
        return view('cms.role.add');
    }

    public function store(RoleRequest $request)
    {
        Role::addRole($request->name);
        return Redirect::route('get.cms.role.index');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('cms.role.edit', compact('role'));
    }

    public function update($id, RoleRequest $request)
    {
        Role::editRole($id, $request->name, $request->guard_name);
        return Redirect::route('get.cms.role.index');
    }

    public function destroy($id)
    {
        Role::deleteRole($id);
        return Redirect::route('get.cms.role.index');
    }
    
    public function getDataTable(Request $request)
    {
        $numberOfRoles = Role::getNumberOfRolesWithQuery($request->input('q'), $request->input('roleId'), $request->input('departmentId'));
        $roles = Role::paginate($request);
        return $this->respondSuccessResponse(["roles" =>  $roles], ['totalItems' => $numberOfRoles]);
    }
}
