<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    // 1. Отримати всі записи з таблиці студентів [cite: 101]
    public function all()
    {
        $students = DB::table('students')->get();
        return response()->json($students);
    }

    // 2. Фільтрація: викладачі конкретної кафедри [cite: 102]
    public function filter()
    {
        $teachers = DB::table('teachers')
            ->where('name', 'like', 'П%') // Починається на П
            ->orWhere('id', '>', 5)
            ->get();
        return response()->json($teachers);
    }

    // 3. Вибір конкретних колонок з аліасами [cite: 103, 105]
    public function selectedColumns()
    {
        $courses = DB::table('courses')
            ->select('title as course_name', 'credits as study_points')
            ->get();
        return response()->json($courses);
    }

    // 4. Пагінація: по 5 студентів на сторінку [cite: 106]
    public function paginated()
    {
        $students = DB::table('students')->paginate(5);
        return response()->json($students);
    }

    // 5. Агрегати: підрахунок кредитів [cite: 107]
    public function aggregates()
    {
        return response()->json([
            'count' => DB::table('courses')->count(),
            'avg_credits' => DB::table('courses')->avg('credits'),
            'max_credits' => DB::table('courses')->max('credits'),
        ]);
    }

    // 6. Join: Факультет -> Кафедра -> Викладач [cite: 108]
    public function joinInner()
    {
        $data = DB::table('faculties')
            ->join('departments', 'faculties.id', '=', 'departments.faculty_id')
            ->join('teachers', 'departments.id', '=', 'teachers.department_id')
            ->select('faculties.name as faculty', 'departments.name as department', 'teachers.name as teacher')
            ->get();
        return response()->json($data);
    }
    // 7. joinLeft
public function joinLeft()
{
    $data = DB::table('faculties')
        ->leftJoin('departments', 'faculties.id', '=', 'departments.faculty_id')
        ->select('faculties.name', 'departments.name as dept_name')
        ->get();
    return response()->json($data);
}

// 8. joinRight (в SQLite робимо через leftJoin, міняючи таблиці)
public function joinRight()
{
    $data = DB::table('departments')
        ->leftJoin('faculties', 'faculties.id', '=', 'departments.faculty_id')
        ->select('departments.name', 'faculties.name as faculty_name')
        ->get();
    return response()->json($data);
}

// 9. insertUpdateDelete
public function insertUpdateDelete()
{
    // Вставка
    DB::table('courses')->insert(['title' => 'Новий курс', 'credits' => 2]);
    
    // Оновлення
    DB::table('courses')->where('title', 'Новий курс')->update(['credits' => 3]);
    
    // Видалення
    DB::table('courses')->where('credits', '<', 2)->delete();

    return response()->json(['status' => 'Операції виконано']);
}
}