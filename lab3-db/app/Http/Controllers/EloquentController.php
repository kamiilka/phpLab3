<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class EloquentController extends Controller
{
    // Отримати всіх студентів через ORM [cite: 134]
    public function index()
    {
        return response()->json(Student::all());
    }

    // Створення нового студента [cite: 137, 139]
    public function store(Request $request)
    {
        $student = Student::create([
            'full_name' => 'Новий Студент Eloquent',
            'email' => 'eloquent' . rand(1, 100) . '@uzhnu.edu.ua'
        ]);
        return response()->json($student, 201);
    }

    // Робота зі зв'язками: викладач з його кафедрою [cite: 183, 185]
    public function showWithRelation()
    {
        // Eager loading (вирішує проблему N+1) [cite: 185, 229]
        $teachers = Teacher::with('department.faculty')->get();
        return response()->json($teachers);
    }

    public function memoryTest()
{
    $startMemory = memory_get_usage();
    
    // Приклад використання chunk [cite: 144]
    Student::chunk(100, function ($students) {
        // обробка
    });

    return response()->json([
        'memory_peak' => memory_get_peak_usage() / 1024 / 1024 . ' MB'
    ]);
}
}