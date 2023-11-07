<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Data_1_Calculation extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'data_1_calculation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'MainsRCurr',
        'MainsPosKWh',
        'DailyMainsPosKWh',
        'Timestamp',
        'from_unixtime',
        'date',
        'week',
        'diff'
    
    ];

}
