<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Participant;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari query params, default ke hari ini
        $date = $request->query('date', now()->toDateString());

        // Ambil data participant yang sudah hadir di tanggal tersebut
        $attended = Attendance::with('participant')
            ->whereDate('event_date', $date)
            ->get();

        return response()->json([
            'status' => 'success',
            'date' => $date,
            'data' => $attended
        ]);
    }

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
            ->where('event_date', $today)
            ->exists();

        if ($alreadyChecked) {
            return response()->json([
                'status' => 'info',
                'message' => 'Sudah check-in hari ini'
            ]);
        }

        Attendance::create([
            'participant_id' => $participant->id,
            'event_date'     => $today,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in berhasil',
            'participant' => $participant
        ]);
    }
}
