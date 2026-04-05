<?php

namespace App\Http\Controllers;

use App\Models\VolunteerAttendance;
use Illuminate\Http\Request;

class VolunteerAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = VolunteerAttendance::with(['user', 'sppg']);

        if ($request->has('sppg_id') && $request->sppg_id != '') {
            $query->where('sppg_id', $request->sppg_id);
        }

        $attendances = $query->latest()->paginate(20);
        $sppgs = \App\Models\Sppg::all();
        
        return view('attendances.index', compact('attendances', 'sppgs'));
    }
}
