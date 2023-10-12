<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
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

    public function getPhotoValueAttribute()
    {
        return $this->value['photo'];
    }

    public function getTextValueAttribute(): string
    {
        $text = $this->value['text'];
        if (str_contains($text, '$time')) {
            $time = now()->diffForHumans(Carbon::make(env('TIME')), CarbonInterface::DIFF_ABSOLUTE, false, 7);
            $text = str_replace('$time', $time, $text);
        }

        return $text;
    }

}
