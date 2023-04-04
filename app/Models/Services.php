<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'user_id',
        'payment_method',
        'payment_service',
    ];

    public function Stores()
    {
        return $this->belongsToMany(Stores::class);
    }
}
