<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        // Очищаємо таблиці перед заповненням
        DB::table('faculties')->delete();

        // 1. Додаємо факультети
        $itId = DB::table('faculties')->insertGetId([
            'name' => 'Факультет інформаційних технологій',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // 2. Додаємо кафедри
        $deptId = DB::table('departments')->insertGetId([
            'name' => 'Кафедра програмних систем',
            'faculty_id' => $itId,
            'created_at' => now(), 'updated_at' => now()
        ]);

        // 3. Додаємо викладачів (Eloquent style для різноманіття)
        \App\Models\Teacher::create([
            'name' => 'Петров Іван Іванович',
            'department_id' => $deptId
        ]);

        // 4. Додаємо курси
        \App\Models\Course::create(['title' => 'Програмування на PHP', 'credits' => 5]);
        \App\Models\Course::create(['title' => 'Бази даних', 'credits' => 4]);

        // 5. Додаємо студентів (багато, через цикл)
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Student::create([
                'full_name' => "Студент №$i",
                'email' => "student$i@uzhnu.edu.ua"
            ]);
        }
    }
}