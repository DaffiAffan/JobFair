<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParticipantRequest $request)
    {


        $validator = Validator::make($request->all(), [
            'name'                        => 'required|string|max:255',
            'email'                       => 'required|email|unique:participants,email|max:255',
            'phone_number'                => 'required|numeric|unique:participants,phone_number',
            'gender'                      => 'required|in:Pria,Wanita',
            'birth_place'                 => 'required|string|max:255',
            'birth_date'                  => 'required|date',
            'address'                     => 'required|string|max:255',
            'last_education'              => 'required|string|max:255',
            'last_education_institution'  => 'required|string|max:255',
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
            'email'                      => $request->email,
            'phone_number'               => $request->phone_number,
            'gender'                     => $request->gender,
            'birth_place'                => $request->birth_place,
            'birth_date'                 => $request->birth_date,
            'address'                    => $request->address,
            'last_education'             => $request->last_education,
            'last_education_institution' => $request->last_education_institution,
        ]);

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
        //
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
}
