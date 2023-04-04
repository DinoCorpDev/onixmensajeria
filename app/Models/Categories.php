<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['name'];

    public function Stores()
    {
        return $this->belongsToMany(Stores::class);
    }
}
