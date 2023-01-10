<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\cms\CountryRequest;
use App\Models\Country;
use Illuminate\Support\Facades\Redirect;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::getAllCountries();
        return view('cms.country.index', compact('countries'));
    }

    public function add()
    {
        return view('cms.country.add');
    }

    public function store(CountryRequest $request)
    {
        Country::addCountry($request->name , $request->iso_code);
        return Redirect::route('get.cms.country.index');
    }

    public function edit($id)
    {
        $country = Country::find($id);
        if (is_null($country))
            return Redirect::route('get.cms.country.index');

        return view('cms.country.edit', compact('country'));
    }

    public function update($id, CountryRequest $request)
    {
        Country::editCountry($id, $request->name , $request->iso_code);
        return Redirect::route('get.cms.country.index');
    }

    public function destroy($id)
    {
        Country::deleteCountry($id);
        return Redirect::route('get.cms.country.index');
    }

}
