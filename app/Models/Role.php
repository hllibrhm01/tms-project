<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role as SpatieRole;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name', 'guard_name'
    ];

    public static function getAllRoles()
    {
        return SpatieRole::all();
    }

    public static function getNumberOfRolesWithQuery($searchKey)
    {
        return self::when($searchKey, function($query) use ($searchKey) {
            $query->where('name', 'like', '%'.$searchKey.'%');
        })->count();
    }

    // SpatieRole can throw an exception and need to handle
    public static function getRole($id)
    {
        $role = null;
        try {
            $role = SpatieRole::findById($id);
            $role->permissions;
        } catch (\Exception $e) {
        }
        return $role;
    }

    public static function addRole($name, $guardName = 'web')
    {
        $role = new SpatieRole();
        $role->name = $name;
        $role->guard_name = $guardName;
        $role->save();
        return $role;
    }

    public static function editRole($id, $name, $guardName = 'web')
    {
        $currentRole = self::getRole($id);
        if ($currentRole == null)
            return null;

        $role = SpatieRole::find($id);
        if ($role == null)
            return null;

        $role->name = $name;
        $role->guard_name = $guardName;
        $role->save();
        return $role;
    }

    public static function deleteRole($id)
    {
        $role = SpatieRole::find($id);

        if(!is_null($role)) {
            $role->syncPermissions(null);
            $role->delete();
        }
        return true;
    }

}
