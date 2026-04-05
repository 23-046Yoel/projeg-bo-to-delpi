<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BeneficiaryGroupController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialLogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecapController;
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
    return view('welcome');
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
    Route::resource('recipes', \App\Http\Controllers\RecipeController::class);
    Route::resource('menus', \App\Http\Controllers\MenuController::class);
    Route::post('orders/{order}/receive', [\App\Http\Controllers\OrderController::class, 'receive'])->name('orders.receive');
    Route::get('/attendances', [\App\Http\Controllers\VolunteerAttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/recap', [RecapController::class, 'index'])->name('recap.index');
    
    Route::get('/inventory', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::resource('orders', \App\Http\Controllers\OrderController::class);
    Route::get('/financial', [\App\Http\Controllers\FinancialController::class, 'index'])->name('financial.index');
    Route::get('/reports/lpd2m', [\App\Http\Controllers\ReportController::class, 'lpd2m'])->name('reports.lpd2m');
    Route::get('/reports/sptj', [\App\Http\Controllers\ReportController::class, 'sptj'])->name('reports.sptj');
    Route::get('/reports/bapsd', [\App\Http\Controllers\ReportController::class, 'bapsd'])->name('reports.bapsd');
    Route::get('/test-wablas', [\App\Http\Controllers\WablasTestController::class, 'test'])->name('test.wablas');

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('distributions', \App\Http\Controllers\DistributionController::class);
    Route::get('/driver/dashboard', [\App\Http\Controllers\DistributionController::class, 'driverDashboard'])->name('distributions.driver');
    Route::post('/distributions/{route}/depart', [\App\Http\Controllers\DistributionController::class, 'depart'])->name('distributions.depart');
    Route::post('/distributions/stops/{stop}/arrive', [\App\Http\Controllers\DistributionController::class, 'arrive'])->name('distributions.arrive');
});

// AI Chat Bot Route (Public)
Route::post('/chat/query', [\App\Http\Controllers\AiChatController::class, 'query'])->name('chat.query');

require __DIR__.'/auth.php';
