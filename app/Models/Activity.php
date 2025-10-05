<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['activity_name','description','date','time','location','club_id','status'];

    public function club(){ return $this->belongsTo(Club::class); }
}
