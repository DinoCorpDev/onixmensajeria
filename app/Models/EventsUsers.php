<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsUsers extends Model
{
    use HasFactory;

    protected $fillable=[
        'idTalent',        
        'id_event',
        'id_user',
        'status',
    ];

    public function events(){
        return $this->hasOne(Events::class, 'id','id_event');
    }
}
