<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Category; // якщо є
use App\Models\Faculty;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    public function index()
    {
        // Eager loading: завантажуємо викладача разом із його кафедрою та факультетом цієї кафедри [cite: 185, 186]
        $teachers = Teacher::with('department.faculty')->get();
        
        return response()->json($teachers);
    }

    public function filterByRelation()
    {
        // Знайти всі факультети, у яких є кафедри [cite: 187]
        $faculties = Faculty::has('departments')->withCount('departments')->get();
        
        return response()->json($faculties);
    }
}