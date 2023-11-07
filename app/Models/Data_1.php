<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class Data_1 extends Model
{

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'data12298';

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
    
    ];

}
