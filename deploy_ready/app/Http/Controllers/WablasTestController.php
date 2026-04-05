<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppService;

class WablasTestController extends Controller
{
    public function test(WhatsAppService $wa)
    {
        $phone = $wa->getMasterNumber();
        $message = "Halo! Ini adalah pesan uji coba dari website Bo To Delpi menggunakan Wablas.\n\nStatus: Terkoneksi (API Key Updated) ✅";
        
        $response = $wa->sendMessage($phone, $message);
        
        return response()->json([
            'message' => 'Pesan uji coba telah dikirim ke ' . $phone,
            'response' => $response ? $response->json() : 'No response from service (check token/domain)',
            'log' => 'Cek storage/logs/laravel.log untuk detailnya'
        ]);
    }
}
