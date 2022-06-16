<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'idevento',
        'titulo',
        'detalle',
        'banner',
        'status'
    ];

    public function eventsOfUsers(){
        return $this->belongsTo(EventsUsers::class);
    }
}
