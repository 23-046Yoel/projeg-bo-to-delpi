<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sppg;
use Illuminate\Http\Request;

class PublicMenuController extends Controller
{
    public function index(Request $request)
    {
        $sppgs = Sppg::all();
        $today = now()->toDateString();

        // Default: show current week
        $startOfWeek = now()->startOfWeek()->toDateString();
        $endOfWeek = now()->endOfWeek()->addDays(14)->toDateString(); // 2 weeks

        $query = Menu::with(['sppg', 'dishes'])
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date');

        if ($request->filled('sppg_id')) {
            $query->where('sppg_id', $request->sppg_id);
        }

        $menus = $query->get()->groupBy('date');

        return view('public.menu_calendar', compact('menus', 'sppgs', 'today'));
    }
}
