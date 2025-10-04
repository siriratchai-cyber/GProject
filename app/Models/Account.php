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
    public function clubs() {
        return $this->belongsToMany(Club::class, 'members', 'student_id', 'club_id', 'std_id', 'id')
        ->withPivot('role', 'status', 'student_id');
    }
    public function members(){
    return $this->hasMany(Member::class);
    }
    use HasFactory;
}
