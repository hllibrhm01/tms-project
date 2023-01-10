<?php

namespace App\Models;

use App\Models\tms\TMSCustomer;
use App\Models\tms\TMSVehicle;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vehicle_id',
        'tms_id',
        'wms_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $guard_name = 'web';


    public static function getAllRoleByUserJoin()
    {
        return self::with('roles')->get();
    }

    public function vehicle()
    {
        return $this->belongsTo(TMSVehicle::class, 'vehicle_id');
    }

    public function customer()
    {
        return $this->belongsTo(TMSCustomer::class, 'tms_id');
    }
    public static function getVehicleAndCustomerFromUser($vehicle_id)
    {
        return self::with('vehicle')->where('vehicle_id', $vehicle_id)->get();
    }

    public static function getCustomerFromUser($tms_id)
    {
        return self::with('customer')->where('tms_id', $tms_id)->get();
    }

    public static function getByEmail($email)
    {
        return self::where("email", $email)->first();
    }

    public static function getUsersByRole($role)
    {
        return self::whereHas("roles", function ($query) use ($role) {
            $query->where("name", $role);
        })->get();
    }

    public static function addUser($name, $email, $password, $vehicle_id, $tms_id)
    {
        $user = new self();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->vehicle_id = $vehicle_id;
        $user->tms_id = $tms_id;
        $user->save();
        return $user;
    }

    public static function editUser($id, $name, $email, $vehicle_id, $tms_id)
    {
        $user = self::find($id);
        if (is_null($id))
            return null;

        $user->name = $name;
        $user->email = $email;
        $user->vehicle_id = $vehicle_id;
        $user->tms_id = $tms_id;
        $user->save();
        return $user;
    }
}
