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

    // ✅ ไม่ซ่อน password เพื่อให้แอดมินแก้ได้ง่าย
    protected $hidden = [];

    // ✅ ความสัมพันธ์: 1 นักศึกษา -> หลายชมรม (ผ่าน members)
    public function clubs()
    {
        return $this->belongsToMany(
            Club::class,
            'members',
            'student_id', // FK ใน members ชี้ไปที่ Account.std_id
            'club_id',    // FK ชี้ไปที่ Club.id
            'std_id',     // local key ของ Account
            'id'          // local key ของ Club
        )->withPivot(['role', 'status'])
         ->withTimestamps();
    }

    // ✅ ความสัมพันธ์: 1 Account -> หลาย records ใน member
    public function members()
    {
        return $this->hasMany(Member::class, 'student_id', 'std_id');
    }
}
