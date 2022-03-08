<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [        
        'email',
        'password',
        'name', 
        'last_name',
        'artistic_name',
        'date_birthday',
        'gender',
        'height',
        'shirt_size',
        'pant_size',
        'shoes_size',
        'hair_color',
        'eyes_color',
        'weight',
        'attitudes',
        'technical_professional',
        'events_participed',
        'description_professional_short',
        'description_professional_long',
        'phone',
        'id_number',
        'address',
        'city',
        'instagram',
        'facebook',
        'twitter',
        'snapchat',
        'youtube_url',
        'spotify',
        'deezer',
        'autorization',
        'photographic_register',
        'pictures',
        'video',
        'state',
        'terms_conditions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function usersRoles(){
        return $this->hasMany(UsersRoles::class, 'id','id_user');
    }
}
