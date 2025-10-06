<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MSensor;

class SensorLaravel extends Controller
{
    // Tampilan utama monitoring
    public function index()
    {
        return view('monitoring'); // file Blade monitoring.blade.php
    }

    // Ambil suhu terbaru (untuk realtime)
    public function getSuhu()
    {
        $sensor = MSensor::latest()->first();
        return $sensor ? $sensor->suhu : 0;
    }

    // Ambil kelembapan terbaru (untuk realtime)
    public function getKelembapan()
    {
        $sensor = MSensor::latest()->first();
        return $sensor ? $sensor->kelembapan : 0;
    }

    // Ambil data terakhir 20 record untuk chart
    public function getSensorData()
    {
        $data = MSensor::latest()->take(20)->get(['suhu','kelembapan','created_at'])->reverse()->values();
        return response()->json($data);
    }
    public function simpansensor()
    {
        MSensor::where('id', '1')->update(['suhu' => request()->nilaisuhu, 'kelembapan' => request()->nilaikelemnapan]);
    }
}
