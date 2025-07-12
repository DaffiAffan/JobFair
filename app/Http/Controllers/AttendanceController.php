<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Participant;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function scan(Request $request)
    {
        $ticket = $request->input('id_ticket');

        $participant = Participant::where('id_ticket', $ticket)->first();

        if (!$participant) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR tidak valid'
            ], 404);
        }

        $today = now()->toDateString();

        $alreadyChecked = Attendance::where('participant_id', $participant->id)
            ->where('attendance_date', $today)
            ->exists();

        if ($alreadyChecked) {
            return response()->json([
                'status' => 'info',
                'message' => 'Sudah check-in hari ini'
            ]);
        }

        Attendance::create([
            'participant_id'   => $participant->id,
            'attendance_date'  => $today,
            'session'          => $this->getSessionFromDate($today),
            'scanned_at'       => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in berhasil',
            'participant' => $participant
        ]);
    }

    private function getSessionFromDate($date)
    {
        // Ganti dengan tanggal acara kamu
        return match ($date) {
            '2025-07-23' => 'hari_1',
            '2025-07-24' => 'hari_2',
            default => 'lainnya'
        };
    }
}
