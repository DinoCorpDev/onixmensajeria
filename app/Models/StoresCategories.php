<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoresCategories extends Model
{
    use HasFactory;

    protected $table = 'categories_stores';
    protected $guarded = ['id'];
    protected $fillable = [
        'stores_id',
        'categories_id',
    ];
}
