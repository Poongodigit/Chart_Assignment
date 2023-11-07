<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master_Tables extends Model
{

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'master_tables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'model_name'
    
    ];

}
