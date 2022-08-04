<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // protected $primaryKey = 'group_id';

    protected $fillable = [
        'descr',
        'long_descr',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id')->withTimestamps();
    }
}
