<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = Participant::all();

        return response()->json([
            'success' => true,
            'message' => 'Data participants retrieved successfully',
            'data' => $participants
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParticipantRequest $request)
    {


        $validator = Validator::make($request->all(), [
            'name'                         => 'required|string|max:255',
            'phone_number'                 => 'required|string|unique:participants,phone_number',
            'gender'                       => 'required|in:Pria,Wanita',
            'birth_place'                  => 'required|string|max:255',
            'birth_date'                   => 'required|date',
            'district'                     => 'required|string|max:255',
            'sub_district'                 => 'required|string|max:255',
            'address'                      => 'required|string|max:255',
            'last_education'               => 'required|string|max:255',
            'education_major'              => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 409);
        }

        // Generate UUID dan id_ticket unik
        $uuid = (string) Str::uuid();
        $idTicket = strtoupper('JF-' . Str::random(10));

        // Pastikan unik (loop jika perlu)
        while (Participant::where('id_ticket', $idTicket)->exists()) {
            $idTicket = strtoupper('JF-' . Str::random(10));
        }

        // Simpan ke database
        $participant = Participant::create([
            'id'                         => $uuid,
            'id_ticket'                  => $idTicket,
            'name'                       => $request->name,
            'phone_number'               => $request->phone_number,
            'gender'                     => $request->gender,
            'birth_place'                => $request->birth_place,
            'birth_date'                 => $request->birth_date,
            'district'                   => $request->district,
            'sub_district'               => $request->sub_district,
            'address'                    => $request->address,
            'last_education'             => $request->last_education,
            'education_major'            => $request->education_major,
        ]);

        $qr = QrCode::format('png')->size(400)->generate($participant->id_ticket);
        $filename = $participant->id_ticket . '.png';
        $path = storage_path("app/public/qrcodes/{$filename}");
        file_put_contents($path, $qr);


        $this->sendWhatsapp(
            $participant->phone_number,
            "Halo {$participant->name}, berikut adalah QR Code untuk keperluan check-in JobFair 2025. ID Tiket: {$participant->id_ticket}",
            $filename
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Data peserta berhasil disimpan.',
            'data' => $participant
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Participant $participant)
    {
        return response()->json([
            'status' => 'success',
            'data' => $participant
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParticipantRequest $request, Participant $participant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        //
    }

    public function sendWhatsapp($phone, $message, $imageFilename = null)
    {
        $token = env('FONNTE_TOKEN');

        $data = [
            'target' => $phone,
            'message' => $message,
            'delay' => '1-45'
        ];

        if ($imageFilename) {
            // production
            // $data['image'] =  env('APP_URL') . '/storage/qrcodes/' . $imageFilename;

            // testing
            $data['url'] = 'https://68cf43816f9b.ngrok-free.app/storage/qrcodes/' . $imageFilename;
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders(['Authorization' => $token])->post('https://api.fonnte.com/send', $data);

            return $response->successful()
                ? $response->json()
                : ['status' => false, 'message' => 'Gagal mengirim WA', 'response' => $response->body()];
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return [
                'status' => false,
                'message' => 'Timeout saat menghubungi Fonnte',
                'error' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengirim WA',
                'error' => $e->getMessage()
            ];
        }
    }
}
