<?php

namespace App\Http\Controllers;

use App\Models\Participant;
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
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:participants|max:255',
            'phone_number'    => 'required|numeric|unique:participants',
            'gender'          => 'required|in:male,female',
            'birth_place'     => 'required|string|max:255',
            'birth_date'      => 'required|date',
            'last_education'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan ke database
        $participant = Participant::create($request->all());

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
