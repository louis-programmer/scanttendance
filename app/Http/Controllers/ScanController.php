<?php
# before editing
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        // input validation
        $request->validate([
            'attendance_code' => 'required|string|max:255',
            'gate' => 'required|string|max:50',
        ]);

        $code = $request->attendance_code;
        //$gate = $request->gate;
        $gate = 'Gate 1A'; // hardcoded per terminal

        // 1. Find attendee
        $attendee = DB::table('attendees')
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
        $lastLog = DB::table('attendance_logs')
            ->where('attendance_code', $code)
            ->where('date', $today)
            ->orderByDesc('id')
            ->first();

        // 3. Determine IN/OUT
        $logType = (!$lastLog)
            ? 'in'
            : ($lastLog->log === 'in' ? 'out' : 'in');

                            // Backend-level protection | prevent spam
                            $lastLog = DB::table('attendance_logs')
                ->where('attendance_code', $code)
                ->where('date', $today)
                ->orderByDesc('id')
                ->first();

            // ✅ cooldown check HERE
            $cooldownSeconds = 5; // adjustable

            if ($lastLog) {
                $lastDateTime = \Carbon\Carbon::parse($lastLog->date . ' ' . $lastLog->time);

                if (now()->diffInSeconds($lastDateTime) < $cooldownSeconds) {
                    return response()->json([
                        'name' => $attendee->first_name . ' ' . $attendee->last_name,
                        'status' => 'TOO FAST',
                        'gate' => $gate,
                        'time' => now()->format('H:i:s')
                    ]);
                }
            }


        // 4. Insert log
        DB::table('attendance_logs')->insert([
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
    }
}