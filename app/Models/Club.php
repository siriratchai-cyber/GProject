<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];


    public function members()
{
    return $this->hasMany(Member::class, 'club_id');
}



    public function accounts()
    {
        return $this->belongsToMany(
            Account::class,
            'members',
            'club_id',
            'student_id',
            'id',
            'std_id'
        )->withPivot(['role', 'status'])
         ->withTimestamps();
    }


    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
