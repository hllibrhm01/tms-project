<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CRMSector extends Model
{
    use SoftDeletes;

    protected $table = 'sectors';

    protected $fillable = ['name'];

}
