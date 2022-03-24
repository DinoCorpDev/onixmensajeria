<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'required_personal',
        'personal_type',
        'personal_quantity',
        'date_initial',
        'date_final',
        'hourly',
        'place',
        'total_budget',
        'daily_budget',
        'status',
        'qr_code',
    ];
}
