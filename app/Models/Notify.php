<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notify extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name', 'banner', 'type', 'schedule', 'category_id', 'current_content', 'count',
    ];

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

}
