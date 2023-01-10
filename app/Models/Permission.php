<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use \Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $guard_name = 'web';

    protected $fillable = [
        'module_id', 'name', 'guard_name'
    ];

    public static function scopeName($query, $name)
    {
        return $query->where("name", $name);
    }

    public static function getAllPermissions()
    {
        return SpatiePermission::all();
    }

    public static function getPermission($id)
    {
        return SpatiePermission::findById($id);
    }


    public static function getPermissionByFields( $name, $guardName)
    {
        return SpatiePermission::where('name', '=', $name)
            ->where('guard_name', '=', $guardName)
            ->first();
    }

    public static function addPermission($name, $guardName)
    {
        $permission = self::getPermissionByFields($name, $guardName);
        if ($permission != null)
            return null;

        $permission = new SpatiePermission();
        $permission->name = $name;
        $permission->guard_name = $guardName;
        $permission->save();
        return $permission;
    }

    public static function editPermission($id, $name, $guardName)
    {
        $currentPermission = self::getPermissionByFields($name, $guardName);
        if ($currentPermission != null)
            return null;

        $permission = self::find($id);
        if ($permission == null)
            return null;

        $permission->name = $name;
        $permission->guard_name = $guardName;
        $permission->save();
        return $permission;
    }

    public static function deletePermission($id)
    {
        $permission = SpatiePermission::find($id);
        if ($permission == null)
            return false;

        $permission->delete();
        return true;
    }
}
