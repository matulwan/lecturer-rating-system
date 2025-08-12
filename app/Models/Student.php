<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',      // Foreign key to users
        'semester',     // Current semester
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}