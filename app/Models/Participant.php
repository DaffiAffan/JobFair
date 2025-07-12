<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\ParticipantFactory> */
    use HasFactory;

    protected $table = 'participants';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'gender',
        'birth_place',
        'birth_date',
        'last_education',
        'id_ticket',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($participant) {
            if (empty($participant->id)) {
                $participant->id = (string) Str::uuid();
            }
        });
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
