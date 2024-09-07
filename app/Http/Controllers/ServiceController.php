<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'range' => 'nullable|numeric',
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $range = $request->input('range', 25);

        $services = DB::table('provider_services')
            ->select('*', DB::raw("
            ( 6371 * acos( cos( radians($latitude) ) * cos( radians( latitude ) )
            * cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) )
            * sin( radians( latitude ) ) ) ) AS distance
        "))
            ->having('distance', '<=', $range)
            ->orderBy('distance', 'asc')
            ->get();

        if ($services->isEmpty()) {
            return response()->json(['message' => 'No services found within the specified range'], 404);
        }

        return response()->json([
            'message' => 'Services found',
            'services' => $services
        ]);
    }
}
