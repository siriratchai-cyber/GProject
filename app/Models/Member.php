<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['club_id', 'name', 'student_id', 'role'];

    public function club() {
        return $this->belongsTo(Club::class);
    }
    public function account() {
        return $this->hasMany(Account::class);
    }
}
