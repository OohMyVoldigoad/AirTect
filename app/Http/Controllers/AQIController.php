<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aqi;
use Illuminate\Support\Facades\Http;

class AQIController extends Controller
{
    public function fetchAndSaveAQI(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'keyword' => 'required',
        ]);

        $token = $request->input('token');
        $keyword = $request->input('keyword');

        $url = "https://api.waqi.info/v2/search/?token={$token}&keyword={$keyword}";
        $response = Http::get($url);
        $result = $response->json();

        if (!isset($result['data']) || $result['status'] != 'ok') {
            return redirect()->back()->withErrors(['message' => 'No results found or error occurred!']);
        }

        $stations = [];
        foreach ($result['data'] as $stationData) {
            $stationUrl = "https://api.waqi.info/feed/@{$stationData['uid']}/?token={$token}";
            $stationResponse = Http::get($stationUrl);
            $stationResult = $stationResponse->json();

            if (isset($stationResult['data'])) {
                $station = new Aqi();
                $station->station_name = $stationResult['data']['city']['name'];
                $station->aqi = $stationResult['data']['aqi'];
                $station->time = $stationResult['data']['time']['s'];
                $station->humidity = $stationResult['data']['iaqi']['h']['v'] ?? null;
                $station->temperature = $stationResult['data']['iaqi']['t']['v'] ?? null;
                $station->atmospheric_pressure = $stationResult['data']['iaqi']['p']['v'] ?? null;
                $station->save();

                $stations[] = $station;
            }
        }

        return redirect()->route('database')->with('stations', $stations);
    }
}