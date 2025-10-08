<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'std_name',
        'std_id',
        'email',
        'password',
        'major',
        'role',
        'year'
    ];

    protected $hidden = [];

    public function clubs()
    {
        return $this->belongsToMany(
            Club::class,
            'members',
            'student_id', 
            'club_id',    
            'std_id',     
            'id'          
        )->withPivot(['role', 'status'])
         ->withTimestamps();
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'student_id', 'std_id');
    }
}
