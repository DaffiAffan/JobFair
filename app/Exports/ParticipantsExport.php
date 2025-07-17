<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParticipantsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Participant::select([
            'id_ticket',
            'name',
            'phone_number',
            'gender',
            'birth_place',
            'birth_date',
            'district',
            'sub_district',
            'address',
            'last_education',
            'education_major',
        ])->get();

        // return Participant::all();
    }

    public function headings(): array
    {
        return [
            'ID Tiket',
            'Nama',
            'Nomor HP',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Kecamatan',
            'Kelurahan',
            'Alamat',
            'Pendidikan Terakhir',
            'Jurusan',
        ];
    }
}
