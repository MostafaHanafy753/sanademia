<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::
        when($request->name, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('name_ku', 'like', '%' . $request->name . '%');
        })->get();
        return $this->apiResponse($cities, 'Cities fetched successfully',200);
    }
}
