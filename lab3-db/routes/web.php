<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryBuilderController;
use App\Http\Controllers\RelationshipController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/raw-demo', function () {
    // 1. Створення допоміжної таблиці (виправлено для SQLite) 
    DB::statement('CREATE TABLE IF NOT EXISTS log_entries (id INTEGER PRIMARY KEY, message TEXT, created_at TIMESTAMP)');
    
    // Заповнюємо її одним рядком 
    DB::unprepared("INSERT INTO log_entries (message, created_at) VALUES ('Перший запис у лог', CURRENT_TIMESTAMP)");

    // 2. Вставка даних (INSERT) [cite: 46, 47]
    DB::insert('insert into faculties (name, created_at, updated_at) values (?, ?, ?)', 
        ['Факультет інформаційних технологій', now(), now()]);

    // 3. Оновлення даних (UPDATE) [cite: 48, 49]
    DB::update('update faculties set name = ? where id = ?', ['ФІТ (оновлено)', 1]);

    // 4. Вибірка з параметрами (SELECT) [cite: 40, 42, 45]
    $faculties = DB::select('select * from faculties where id = ?', [1]);

    // 5. Демонстрація транзакції (Transaction) [cite: 51]
    DB::transaction(function () {
        DB::insert('insert into faculties (name, created_at, updated_at) values (?, ?, ?)', ['Економічний факультет', now(), now()]);
        DB::insert('insert into log_entries (message, created_at) values (?, ?)', ['Додано економічний факультет', now()]);
    });

    // Повертаємо результат у форматі JSON 
    return response()->json([
        'message' => 'Raw SQL операції виконано успішно',
        'data' => $faculties,
        'logs' => DB::select('select * from log_entries')
    ]);
});


Route::prefix('qb')->group(function () {
    Route::get('/all', [QueryBuilderController::class, 'all']);
    Route::get('/filter', [QueryBuilderController::class, 'filter']);
    Route::get('/columns', [QueryBuilderController::class, 'selectedColumns']);
    Route::get('/paginated', [QueryBuilderController::class, 'paginated']);
    Route::get('/stats', [QueryBuilderController::class, 'aggregates']);
    Route::get('/join', [QueryBuilderController::class, 'joinInner']);
});
use App\Http\Controllers\EloquentController;

Route::prefix('eq')->group(function () {
    Route::get('/students', [EloquentController::class, 'index']);
    Route::get('/create', [EloquentController::class, 'store']);
    Route::get('/relations', [EloquentController::class, 'showWithRelation']);
});
Route::get('/qb/join-left', [QueryBuilderController::class, 'joinLeft']);
Route::get('/qb/join-right', [QueryBuilderController::class, 'joinRight']);
Route::get('/qb/action', [QueryBuilderController::class, 'insertUpdateDelete']);


Route::get('/relations', [RelationshipController::class, 'index']);
Route::get('/relations/filter', [RelationshipController::class, 'filterByRelation']);