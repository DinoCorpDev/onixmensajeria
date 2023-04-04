<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesStores extends Model
{
    use HasFactory;

    protected $table = 'services_stores';
    protected $guarded = ['id'];
    protected $fillable = [
        'stores_id',
        'services_id',
    ];
}
