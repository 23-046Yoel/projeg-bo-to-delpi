<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WhatsAppLoginController extends Controller
{
    protected $waService;

    public function __construct(WhatsAppService $waService)
    {
        $this->waService = $waService;
    }

    public function showLoginForm()
    {
        return view('auth.login-wa');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->phone;
        
        // Consistent normalization
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '620')) {
            $phone = '62' . substr($phone, 3);
        } elseif (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
        
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Nomor WhatsApp tidak terdaftar di sistem.'], 404);
        }

        $otp = rand(100000, 999999);
        $cacheKey = 'otp_' . $phone;

        // OTP berlaku 10 menit
        Cache::put($cacheKey, $otp, now()->addMinutes(10));
        Log::info("OTP generated for $phone: $otp");

        // Kirim OTP langsung ke WA user
        $userMessage = "*[Bo To Delphi]*\n\nHalo *{$user->name}*! 👋\n\nKode OTP login Anda: *$otp*\n\nBerlaku 10 menit. Jangan berikan ke siapapun.";
        $response = $this->waService->sendMessage($phone, $userMessage);

        // Notifikasi salinan ke admin
        $adminNumber = env('ADMIN_NOTIFICATION_NUMBER', '6285353325352');
        if ($adminNumber && $adminNumber !== $phone) {
            $adminMsg = "*[NOTIF LOGIN]*\n👤 {$user->name}\n📱 +$phone\n🔑 OTP: *$otp*\n🕐 " . now()->format('d/m/Y H:i:s');
            $this->waService->sendMessage($adminNumber, $adminMsg);
        }

        if ($response && $response->successful()) {
            return response()->json(['success' => true, 'message' => 'Kode OTP telah dikirim ke WhatsApp Anda.']);
        }

        Log::error("Failed to send OTP to $phone");
        return response()->json(['success' => false, 'message' => 'Gagal mengirim OTP. Coba lagi.'], 500);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string|size:6',
        ]);

        $phone = $request->phone;
        // Identical normalization
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '620')) {
            $phone = '62' . substr($phone, 3);
        } elseif (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        $cacheKey = 'otp_' . $phone;
        $cachedOtp = Cache::get($cacheKey);

        Log::info("Verifying OTP for $phone: input=$request->otp, cached=$cachedOtp");

        if ($cachedOtp && (string)$cachedOtp === (string)$request->otp) {
            Cache::forget($cacheKey);
            
            $user = User::where('phone', $phone)->first();
            Auth::login($user);

            return response()->json(['success' => true, 'redirect' => route('dashboard')]);
        }

        $message = $cachedOtp ? 'Kode OTP salah.' : 'Kode OTP sudah kadaluarsa atau belum dikirim.';
        return response()->json(['success' => false, 'message' => $message], 422);
    }
}
