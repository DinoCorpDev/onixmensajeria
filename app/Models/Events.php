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
        'personla_quantity',
        'date_initial',
        'date_final',
        'hourly',
        'place',
        'total_budget',
        'daily_budget',
        'qr_code',
    ];
}
