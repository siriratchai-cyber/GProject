<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $fillable = [
        'std_name', 'std_id' , 'email', 'password', 'major', 'role', 'year'
    ];
    public function club() {
        return $this->hasMany(Club::class);
    }
    use HasFactory;
}
