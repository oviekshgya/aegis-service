<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'name',
        'active',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi one-to-many dengan orders
    public function orders()
    {
        return $this->hasMany(orders::class, 'user_id');
    }
}
