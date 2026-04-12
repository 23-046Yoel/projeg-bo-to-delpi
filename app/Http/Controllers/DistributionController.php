<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DistributionRoute;
use App\Models\DistributionStop;
use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DistributionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $sppgId = $user->sppg_id;
        
        $routes = DistributionRoute::when($sppgId, function($query, $sppgId) {
                return $query->where('sppg_id', $sppgId);
            })
            ->with(['driver', 'assistant'])
            ->latest('date')
            ->paginate(10);
            
        // For Admin without specific SPPG, show all schools with coordinates
        if ($user->isAdmin() && !$sppgId) {
            $schools = \App\Models\BeneficiaryGroup::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();
            $allSppgs = \App\Models\Sppg::whereNotNull('latitude')->get();
            $sppg = $allSppgs->first(); // Use first SPPG as default center
        } else {
            $schools = $sppgId 
                ? \App\Models\BeneficiaryGroup::where('sppg_id', $sppgId)
                    ->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->get()
                : collect();
            $allSppgs = $user->sppg ? collect([$user->sppg]) : collect();
            $sppg = $user->sppg;
        }
            
        return view('distributions.index', compact('routes', 'schools', 'sppg', 'allSppgs'));
    }

    public function create()
    {
        $drivers = User::where('sppg_id', auth()->user()->sppg_id)
            ->where('role', User::ROLE_DRIVER)
            ->get();
            
        $groups = \App\Models\BeneficiaryGroup::where('sppg_id', auth()->user()->sppg_id)->get();
        
        return view('distributions.create', compact('drivers', 'groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'nullable|exists:users,id',
            'driver_phone' => 'required_without:driver_id|nullable|string',
            'date' => 'required|date',
            'group_ids' => 'required|array',
            'group_ids.*' => 'exists:beneficiary_groups,id',
        ]);

        $route = DistributionRoute::create([
            'assistant_id' => auth()->id(),
            'driver_id' => $validated['driver_id'] ?? null,
            'driver_phone' => $validated['driver_phone'] ?? null,
            'sppg_id' => auth()->user()->sppg_id,
            'date' => $validated['date'],
            'status' => 'planned',
        ]);

        foreach ($validated['group_ids'] as $index => $groupId) {
            $quantity = $request->input('quantities.'.$groupId, 1);
            DistributionStop::create([
                'distribution_route_id' => $route->id,
                'beneficiary_id' => $groupId,
                'order' => $index + 1,
                'status' => 'pending',
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('distributions.index')->with('success', 'Rute distribusi berhasil disusun.');
    }

    public function driverDashboard()
    {
        $activeRoute = DistributionRoute::where('driver_id', auth()->id())
            ->whereIn('status', ['planned', 'active'])
            ->with(['stops.beneficiaryGroup', 'assistant'])
            ->first();
            
        return view('distributions.driver', compact('activeRoute'));
    }

    public function depart(DistributionRoute $route, Request $request)
    {
        $request->validate([
            'departure_photo' => 'required|image|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $path = $request->file('departure_photo')->store('distributions/departures', 'public');

        $route->update([
            'status' => 'active',
            'departure_time' => now(),
            'departure_photo' => $path,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // WhatsApp Monitoring
        try {
            $wa = app(\App\Services\WhatsAppService::class);
            $bot = app(\App\Services\BoToPersonalityService::class);
            $stops = $route->stops()->with('beneficiaryGroup')->get();
            $routeNames = $stops->pluck('beneficiaryGroup.name')->implode(' -> ');
            
            $locationLink = "";
            if ($request->latitude && $request->longitude) {
                $locationLink = "\n📍 Lokasi: https://www.google.com/maps?q={$request->latitude},{$request->longitude}";
            }

            $msg = "*[LOGISTIK KELUAR]*\nDriver {$route->driver->name} telah berangkat dari SPPG dengan rute: {$routeNames}{$locationLink}";
            $wa->sendMessage($wa->getMasterNumber(), $bot->medanize($msg));
        } catch (\Exception $e) {
            \Log::error("WA Depart Error: " . $e->getMessage());
        }

        return back()->with('success', 'Waktu keberangkatan tercatat. Hati-hati di jalan!');
    }

    public function arrive(DistributionStop $stop, Request $request)
    {
        $request->validate([
            'handover_photo' => 'required|image|max:2048',
            'handover_doc_photo' => 'required|image|max:2048',
        ]);

        $handoverPath = $request->file('handover_photo')->store('distributions/handovers', 'public');
        $docPath = $request->file('handover_doc_photo')->store('distributions/documents', 'public');

        $stop->update([
            'status' => 'completed',
            'arrival_time' => now(),
            'handover_photo' => $handoverPath,
            'handover_doc_photo' => $docPath,
        ]);

        // WhatsApp Monitoring
        try {
            $wa = app(\App\Services\WhatsAppService::class);
            $bot = app(\App\Services\BoToPersonalityService::class);
            $msg = "*[LOGISTIK TERIMA]*\nDriver {$stop->distributionRoute->driver->name} telah sampai di {$stop->beneficiaryGroup->name} dan menyerahkan {$stop->quantity} porsi.";
            $wa->sendMessage($wa->getMasterNumber(), $bot->medanize($msg));
        } catch (\Exception $e) {
            \Log::error("WA Arrive Error: " . $e->getMessage());
        }

        // Check if all stops are completed
        $route = $stop->distributionRoute;
        if ($route->stops()->where('status', 'pending')->count() === 0) {
            $route->update(['status' => 'completed']);
        }

        return back()->with('success', 'Data serah terima berhasil disimpan.');
    }
}
