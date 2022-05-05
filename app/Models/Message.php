<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $appends = ['heart_count', 'recent_heart'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hearts()
    {
        return $this->hasMany(Heart::class);
    }

    public function getHeartCountAttribute()
    {
        return Heart::where('message_id', $this->id)->count();
    }

	public function getRecentHeartAttribute()
	{
		return Heart::where('message_id', $this->id)->orderBy('created_at', 'DESC')->first();
	}
}
