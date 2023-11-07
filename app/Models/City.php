<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class City extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'city';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'state_id',
        'state',
        'country_id',
        'country_code',
        'latitude',
        'longitude'

    ];

}
