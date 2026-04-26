<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $user = User::where('barcode_id', $request->barcode)->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        AttendanceLog::create([
            'user_id' => $user->id,
            'scan_time' => now(),
        ]);

        return back()->with('success', $user->name . ' scanned');
    }
}