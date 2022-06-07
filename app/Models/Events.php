<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['hourly' => 'array'];

    protected $fillable = [
        'idItalentt',
        'name',
        'banner',
        'typePersonal',
        'initialDate',
        'endDate',
        'hourly',
        'city',
        'location',
        'id_address',
        'totalBudget',
        'dailyBudget',
        'status',
    ];

    public function eventsOfUsers()
    {
        return $this->belongsTo(EventsUsers::class);
    }
}
