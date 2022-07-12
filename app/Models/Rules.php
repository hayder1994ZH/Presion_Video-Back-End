<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rules extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'users',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    
    //Relations
    public function users()
    {
        return $this->hasMany(User::class, 'rule_id');
    }

}
