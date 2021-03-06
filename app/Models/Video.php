<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'title', 'description', 'image', 'video', 'user_id', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'user',
    ];
    protected $appends = [
       'image_url', 'video_url'
    ];
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
    public function getVideoUrlAttribute()
    {
        return $this->video ? asset('storage/'.$this->video) : null;
    }
    protected $hidden = [
        'deleted_at',
    ];
    
    //Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
