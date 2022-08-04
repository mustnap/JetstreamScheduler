<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayoffUser extends Model
{
    use HasFactory;

    protected $table = 'dayoff_users';

    protected $fillable = [
        'user_id',
        'date_booked',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
