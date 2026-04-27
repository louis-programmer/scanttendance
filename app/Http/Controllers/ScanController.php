<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

public function store(Request $request)
{
    $code = $request->attendance_code;
    $gate = $request->gate;

    // 1. Find attendee
    $attendee = \DB::table('attendees')
        ->where('attendance_code', $code)
        ->first();

    if (!$attendee) {
    return response()->json([
        'name' => 'Unknown User',
        'status' => 'ERROR',
        'gate' => $gate,
        'time' => now()->format('H:i:s')
    ]);
}
    $today = now()->toDateString();

    // 2. Get last log today
    $lastLog = \DB::table('attendance_logs')
        ->where('attendance_code', $code)
        ->where('date', $today)
        ->orderByDesc('id')
        ->first();

    // 3. Determine IN/OUT
    $logType = (!$lastLog) ? 'in' : ($lastLog->log === 'in' ? 'out' : 'in');

    // 4. Insert log (FIXED)
    \DB::table('attendance_logs')->insert([
        'organization_number' => $attendee->organization_number,
        'attendance_code' => $attendee->attendance_code,
        'shift' => $attendee->shift,
        'gate' => $gate,
        'date' => $today,
        'time' => now()->toTimeString(),
        'log' => $logType,
    ]);

    // 5. Response
     return response()->json([
    'name' => $attendee->first_name . ' ' . $attendee->last_name,
    'status' => strtoupper($logType),
    'gate' => $gate,
    'time' => now()->format('H:i:s')
]);


     return response()->json([
    'name' => 'Unknown User',
    'status' => 'ERROR',
    'gate' => $gate,
    'time' => now()->format('H:i:s')
]);
     
}
}