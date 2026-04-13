<?php

namespace App\Http\Controllers;

use App\Models\Sppg;
use App\Models\BeneficiaryGroup;
use App\Models\News;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    /** Public: List all kitchens */
    public function index()
    {
        $kitchens = Sppg::withSum('beneficiaryGroups', 'total_beneficiaries')->latest()->get();
        return view('kitchen.index', compact('kitchens'));
    }

    /** Public: Show kitchen profile */
    public function show($slug)
    {
        $kitchen = Sppg::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();

        $beneficiaryGroups = BeneficiaryGroup::where('sppg_id', $kitchen->id)
            ->where('total_beneficiaries', '>', 0)
            ->get();

        $news = News::where('sppg_id', $kitchen->id)->latest()->take(4)->get();

        // Determine live status based on operational hours
        $now = now();
        $hours = $kitchen->operational_hours ?? '06:00 - 14:00';
        [$start, $end] = explode(' - ', $hours);
        $isOperational = $now->between(
            $now->copy()->setTimeFromTimeString($start),
            $now->copy()->setTimeFromTimeString($end)
        );

        $onlineUsers = $kitchen->users()->where('last_seen_at', '>=', now()->subMinutes(15))->count();

        return view('kitchen.show', compact('kitchen', 'beneficiaryGroups', 'news', 'isOperational', 'onlineUsers'));
    }
}
