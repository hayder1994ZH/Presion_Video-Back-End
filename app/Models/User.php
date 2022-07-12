<?php

namespace App\Models;

use App\Helpers\Utilities;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'password',
        'image',
        'include_player_ids',
        'email_verified_at',
        'remember_token',
        'rule_id',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $relations = [
        'rule'
    ];
    protected $hidden = [
        'password',
        'image',
        'remember_token',
        'email_verified_at',
        'deleted_at',
    ];
    protected $casts = [
        'city_id' => 'int',
        'rule_id' => 'int',
        'status' => 'boolean',
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $appends = [
       'image_url',
    ];
    public function getImageUrlAttribute()
    {
        return $this->image ? request()->get('host') . Utilities::$imageBucket . $this->image : null;
    }

    //Relations player_id
    public function rule()
    {
        return $this->belongsTo(Rules::class);
    }
}
