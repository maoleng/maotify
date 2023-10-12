<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'value', 'notify_id',
    ];

    protected $casts = [
        'value' => 'json',
    ];

}
