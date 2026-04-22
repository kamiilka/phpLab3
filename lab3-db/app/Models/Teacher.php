<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'department_id'];

    // Викладач належить кафедрі
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}