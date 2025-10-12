<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Thana;
use App\Models\Union;

class GeoController extends Controller
{
    // Show the initial page with all divisions
    public function index()
    {
        $divisions = Division::all(); // You can filter by status if needed
        return view('locations.index', compact('divisions'));
    }

    // AJAX: Get districts by division
    public function getDistricts($division_id)
    {
        $districts = District::where('division_id', $division_id)->get();
        return response()->json($districts);
    }

    // AJAX: Get thanas by district
    public function getThanas($district_id)
    {
        $thanas = Thana::where('district_id', $district_id)->get();
        return response()->json($thanas);
    }

    // AJAX: Get unions by thana
    public function getUnions($thana_id)
    {
        $unions = Union::where('thana_id', $thana_id)->get();
        return response()->json($unions);
    }
}
