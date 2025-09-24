<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image'];

    public function members(){
        return $this->hasMany(Member::class);
    }
    public function accounts() {
        return $this->belongsToMany(Account::class);
    }
    public function activities(){
        return $this->hasMany(Activity::class);
    }
}
