<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'faculty_id'];

    // Кафедра належить факультету
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    // Кафедра має багато викладачів
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}