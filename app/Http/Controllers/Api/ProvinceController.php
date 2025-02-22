<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $provinces = Province::when($request->name, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('name_ku', 'like', '%' . $request->name . '%');
        })->when($request->city_id, function ($query) use ($request) {
            $query->where('city_id', $request->city_id);
        })
            ->with('city')
            ->get();
        return $this->apiResponse($provinces, 'Provinces fetched successfully', 200);
    }
}
