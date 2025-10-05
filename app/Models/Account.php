<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'std_name', 'std_id' , 'email', 'password', 'major', 'role', 'year'
    ];

    // ซ่อนรหัสผ่านเวลา serialize
    protected $hidden = ['password'];

    public function clubs() {
        return $this->belongsToMany(Club::class, 'members', 'student_id', 'club_id', 'std_id', 'id')
            ->withPivot('role', 'status', 'student_id');
    }

    public function members(){
        return $this->hasMany(Member::class, 'student_id', 'std_id');
    }
}
