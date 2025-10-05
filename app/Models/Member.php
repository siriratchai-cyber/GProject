<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'name',
        'student_id',
        'role',
        'status'
    ];

    // ✅ ความสัมพันธ์กับชมรม
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    // ✅ ความสัมพันธ์กับบัญชีผู้ใช้
   public function account()
{
    return $this->belongsTo(\App\Models\Account::class, 'student_id', 'std_id');
}

}
