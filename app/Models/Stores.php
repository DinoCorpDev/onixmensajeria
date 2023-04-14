<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;

    protected $table = 'stores';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'phone',
        'location',
        'user_id',
        'state',
        'avatar',
    ];

    protected $casts = ['payment_method' => 'array'];

    public function categories()
    {
        return $this->belongsToMany(Categories::class);
    }

    public function drivers()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
