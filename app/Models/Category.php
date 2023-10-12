<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name', 'channel',
    ];

    public function notifies(): HasMany
    {
        return $this->hasMany(Notify::class);
    }

}
