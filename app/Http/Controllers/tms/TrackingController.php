<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TrackingController extends Controller
{
    public function index() {

        return view('tms.order.tracking');
    }
}
