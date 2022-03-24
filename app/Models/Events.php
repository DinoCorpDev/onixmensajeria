<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'idItalentt',
        'name',
        'banner',
        'typePersonal',
        'initialDate',
        'endDate',
        'houry',
        'city',
        'location',
        'id_address',
        'totalBudget',
        'dailyBudget',
        'status',
    ];
}
