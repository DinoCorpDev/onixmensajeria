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
        'description',
        'image',
        'location',
        'id_user',
        'state',
        'schedule',
        'avatar',
    ];

    protected $casts = ['payment_method' => 'array', 'schedule' => 'object'];

    public function services()
    {
        return $this->belongsToMany(Services::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class);
        // return $this->hasMany(StoresCategories::class,'id_store','id');
    }
}
