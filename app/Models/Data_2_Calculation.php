<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_2_Calculation extends Model
{

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'data_2_calculation';

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
