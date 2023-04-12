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
        'id_user',
        'state',
        'avatar',
    ];

    protected $casts = ['payment_method' => 'array'];

    public function categories()
    {
        return $this->belongsToMany(Categories::class);
    }
}
