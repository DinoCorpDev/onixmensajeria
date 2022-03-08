<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsUsers extends Model
{
    use HasFactory;

    protected $fillable=[
        'status',
        'id_event',
        'id_user',
    ];
}
