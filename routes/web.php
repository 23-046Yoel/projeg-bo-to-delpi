<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BeneficiaryGroupController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialLogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\SupplierRegistrationController;
use App\Http\Controllers\RequirementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\WhatsAppLoginController;

Route::get('/', function () {
    $totalBeneficiaries = \App\Models\BeneficiaryGroup::sum('total_beneficiaries');
    $stats = [
        'posts_count' => \App\Models\News::count() + \App\Models\Aspiration::count(),
        'beneficiaries_per_kitchen' => \App\Models\Sppg::count() > 0 
            ? round($totalBeneficiaries / \App\Models\Sppg::count()) 
            : $totalBeneficiaries,
        'tutorials_count' => \App\Models\Dish::whereNotNull('youtube_url')->count(),
        'beneficiaries_count' => $totalBeneficiaries,
    ];
    return view('welcome', compact('stats'));
});

// Redirect standard login to WA login
Route::get('/login', function () {
    return redirect()->route('login.wa');
});

// WA Login Routes
Route::get('/login-wa', [WhatsAppLoginController::class, 'showLoginForm'])->name('login.wa');
Route::post('/login-wa/send', [WhatsAppLoginController::class, 'sendOtp'])->name('login.wa.send');
Route::post('/login-wa/verify', [WhatsAppLoginController::class, 'verifyOtp'])->name('login.wa.verify');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('suppliers', SupplierController::class);
    Route::resource('beneficiaries', BeneficiaryController::class);
    Route::resource('beneficiary-groups', BeneficiaryGroupController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('material_logs', MaterialLogController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('sppgs', \App\Http\Controllers\SppgController::class);
    Route::resource('dishes', \App\Http\Controllers\DishController::class);
    Route::get('dishes/{dish}/tutorial', [\App\Http\Controllers\DishController::class, 'tutorial'])->name('dishes.tutorial');
    Route::resource('recipes', \App\Http\Controllers\RecipeController::class);
    Route::resource('menus', \App\Http\Controllers\MenuController::class);
    Route::post('orders/{order}/receive', [\App\Http\Controllers\OrderController::class, 'receive'])->name('orders.receive');
    Route::get('/attendances', [\App\Http\Controllers\VolunteerAttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/recap', [RecapController::class, 'index'])->name('recap.index');
    
    Route::get('/inventory', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/adjust', [\App\Http\Controllers\InventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::get('/orders/daily', [\App\Http\Controllers\OrderController::class, 'dailyReport'])->name('orders.daily');
    Route::get('/orders/calculate-requirements', [\App\Http\Controllers\OrderController::class, 'getRequirementsJson'])->name('orders.calculate');
    Route::get('/sppgs/{sppg}/portions', [\App\Http\Controllers\MenuController::class, 'getSppgPortions'])->name('sppgs.portions');
    Route::resource('orders', \App\Http\Controllers\OrderController::class);
    Route::get('/financial', [\App\Http\Controllers\FinancialController::class, 'index'])->name('financial.index');
    Route::get('/reports/lpd2m', [\App\Http\Controllers\ReportController::class, 'lpd2m'])->name('reports.lpd2m');
    Route::get('/reports/sptj', [\App\Http\Controllers\ReportController::class, 'sptj'])->name('reports.sptj');
    Route::get('/reports/bapsd', [\App\Http\Controllers\ReportController::class, 'bapsd'])->name('reports.bapsd');
    Route::get('/reports/upload', [\App\Http\Controllers\ReportController::class, 'uploadIndex'])->name('reports.upload');
    Route::post('/reports/save', [\App\Http\Controllers\ReportController::class, 'saveReport'])->name('reports.save');
    Route::post('/reports/upload', [\App\Http\Controllers\ReportController::class, 'uploadStore'])->name('reports.upload.store');
    Route::get('/test-wablas', [\App\Http\Controllers\WablasTestController::class, 'test'])->name('test.wablas');

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::get('/users/{user}/signature', [\App\Http\Controllers\UserController::class, 'signatureForm'])->name('users.signature.form');
    Route::post('/users/{user}/signature', [\App\Http\Controllers\UserController::class, 'signatureUpload'])->name('users.signature.upload');
    Route::resource('news', \App\Http\Controllers\NewsController::class);
    Route::resource('distributions', \App\Http\Controllers\DistributionController::class);
    Route::get('/driver/dashboard', [\App\Http\Controllers\DistributionController::class, 'driverDashboard'])->name('distributions.driver');
    Route::post('/distributions/{route}/depart', [\App\Http\Controllers\DistributionController::class, 'depart'])->name('distributions.depart');
    Route::post('/distributions/stops/{stop}/arrive', [\App\Http\Controllers\DistributionController::class, 'arrive'])->name('distributions.arrive');
    Route::resource('complaints', \App\Http\Controllers\ComplaintController::class)->only(['index', 'update']);
    Route::get('/kebutuhan-bahan', [RequirementController::class, 'index'])->name('requirements.index');
    Route::post('/kebutuhan-bahan/hitung', [RequirementController::class, 'calculate'])->name('requirements.calculate');

    // Daily Report (auth required)
    Route::get('/laporan-harian', [\App\Http\Controllers\NutritionController::class, 'dailyReport'])->name('reports.daily');
    Route::post('/laporan-harian', [\App\Http\Controllers\NutritionController::class, 'storeDailyReport'])->name('reports.daily.store');

    // Admin: List of consultation registrations
    Route::get('/admin/konsultasi-gizi', [\App\Http\Controllers\NutritionController::class, 'consultationList'])->name('nutrition.consultation.list');
});

// Public Accessibility Routes
// Nutrition Consultation is public - anyone can register
Route::get('/konsultasi-gizi', [\App\Http\Controllers\NutritionController::class, 'consultation'])->name('nutrition.consultation');
Route::post('/konsultasi-gizi', [\App\Http\Controllers\NutritionController::class, 'storeConsultation'])->name('nutrition.consultation.store');

Route::get('/prices', [\App\Http\Controllers\PublicPriceController::class, 'index'])->name('prices.index');
Route::get('/jadwal-menu', [\App\Http\Controllers\PublicMenuController::class, 'index'])->name('public.menu');
Route::get('/complaints/create', [\App\Http\Controllers\ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/complaints', [\App\Http\Controllers\ComplaintController::class, 'store'])->name('complaints.store');

Route::get('/pendaftaran-pemasok', [SupplierRegistrationController::class, 'index'])->name('suppliers.register');
Route::post('/pendaftaran-pemasok', [SupplierRegistrationController::class, 'store'])->name('suppliers.register.store');

// AI Chat Bot Route (Public)
Route::post('/chat/query', [\App\Http\Controllers\AiChatController::class, 'query'])->name('chat.query');

// Public API: Menu Hari Ini (untuk AI & integrasi)
Route::get('/api/menu-hari-ini', function () {
    $today = now()->toDateString();
    $menus = \App\Models\Menu::with(['sppg', 'dishes'])
        ->whereBetween('date', [$today, now()->addDays(7)->toDateString()])
        ->orderBy('date')
        ->get()
        ->map(function ($menu) use ($today) {
            return [
                'tanggal'        => \Carbon\Carbon::parse($menu->date)->translatedFormat('l, d F Y'),
                'hari_ini'       => $menu->date === $today,
                'dapur'          => $menu->sppg->name ?? 'Semua Dapur',
                'karbo'          => $menu->karbo,
                'protein_hewani' => $menu->protein_hewani,
                'protein_nabati' => $menu->protein_nabati,
                'sayur'          => $menu->sayur,
                'buah'           => $menu->buah,
                'pelengkap'      => $menu->pelengkap,
                'hidangan'       => $menu->dishes->pluck('name'),
            ];
        });
    return response()->json(['success' => true, 'data' => $menus]);
})->name('api.menu-hari-ini');

// Public Portal Routes
Route::post('/aspirasi', [\App\Http\Controllers\AspirationController::class, 'store'])->name('aspirations.store');
Route::get('/dapur', [\App\Http\Controllers\KitchenController::class, 'index'])->name('kitchens.index');
Route::get('/dapur/{slug}', [\App\Http\Controllers\KitchenController::class, 'show'])->name('kitchens.show');
Route::get('/harga-komunitas', [\App\Http\Controllers\CommunityPriceController::class, 'index'])->name('community-prices.index');
Route::post('/harga-komunitas', [\App\Http\Controllers\CommunityPriceController::class, 'store'])->name('community-prices.store');
Route::post('/harga-komunitas/{price}/like', [\App\Http\Controllers\CommunityPriceController::class, 'like'])->name('community-prices.like');

// Admin Aspiration Moderation (Auth required)
Route::middleware('auth')->group(function () {
    Route::get('/admin/aspirasi', [\App\Http\Controllers\AspirationController::class, 'index'])->name('aspirations.index');
    Route::post('/admin/aspirasi/{aspiration}/toggle', [\App\Http\Controllers\AspirationController::class, 'toggle'])->name('aspirations.toggle');
    Route::post('/admin/aspirasi/{aspiration}/pin', [\App\Http\Controllers\AspirationController::class, 'pin'])->name('aspirations.pin');
    Route::delete('/admin/aspirasi/{aspiration}', [\App\Http\Controllers\AspirationController::class, 'destroy'])->name('aspirations.destroy');
});

// Maintenance Routes
Route::get('/bersihkan-sistem', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('view:cache');
    \Illuminate\Support\Facades\Artisan::call('route:cache');
    return "Sistem berhasil dibersihkan! <br><a href='/'>Kembali ke Home</a>";
});

Route::get('/pindah-storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return "Storage link berhasil dibuat! <br><a href='/'>Kembali ke Home</a>";
});

Route::get('/jalankan-migrasi-baru-8x92k', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return "<pre style='font-family:monospace;padding:20px;background:#0F172A;color:#D4AF37'>✅ MIGRASI BERHASIL!\n\n" . $output . "\n\n<a href='/' style='color:white'>Kembali ke Home</a></pre>";
    } catch (\Exception $e) {
        return "<pre style='color:red;padding:20px'>❌ Gagal: " . $e->getMessage() . "</pre>";
    }
});

require __DIR__.'/auth.php';
