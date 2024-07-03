<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Aqi;
use App\Models\Sensorreceive;
use App\Models\Saran;

class PageController extends Controller
{
    public function showLoginPage(){
        return view('auth/login');
    }

    public function welcomePage()
    {
        $token = '32c5640caacbd1f1945d22860184aaf0db4a380e';
        $keyword = 'batam';

        $url = "https://api.waqi.info/v2/search/?token={$token}&keyword={$keyword}";
        $response = Http::get($url);
        $result = $response->json();

        if (!isset($result['data']) || $result['status'] != 'ok') {
            return view('welcome')->withErrors(['message' => 'No results found or error occurred!']);
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

        // Mengambil stasiun pertama untuk ditampilkan
        $station = $stations[0] ?? null;

        return view('sensor', compact('station'));
    }

    public function dashboardAdmin(){
        return view("dashboardAdmin");
    }

    public function index()
    {
        // Mengambil data terbaru dari tabel SensorReceive
        $latestData = SensorReceive::latest()->first();
        
        // Memeriksa nilai CH4 pada data terbaru
        if ($latestData && $latestData->CH4 == 0) {
            // Jika nilai CH4 adalah 0, mengambil saran dengan tipe 'sehat'
            $images = Saran::where('tipe', 'sehat')->get();
        } elseif ($latestData && $latestData->CH4 == 1) {
            // Jika nilai CH4 adalah 1, mengambil saran dengan tipe 'danger'
            $images = Saran::where('tipe', 'danger')->get();
        } else {
            // Jika data terbaru tidak ada atau tidak memenuhi kondisi di atas, mengambil semua saran
            $images = Saran::get();
        }
    
        return view('welcome', compact('latestData', 'images'));
    }
    
}
