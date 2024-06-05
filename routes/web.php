<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaOfInterestController;
use App\Http\Controllers\GlobalCoursesController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DocumentController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

 Route::get('/', function () {
    return view('welcome');
});
Route::get('/privacy', function () {
    return view('policy');
});
Route::get('/terms', function () {
    return view('terms');
});
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/dashboard-table', function () {
    return view('admin.tables');
});
Route::get('/logout', [
    AuthenticatedSessionController::class,
    'destroy'
])->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard-index', function () {
        return redirect(route('admin.user'));   
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return redirect(route('admin.user'));   
    })->name('dashboard');

    Route::get('/dashboard/chart', function () {
        return redirect(route('admin.user'));   
    })->name('dashboard.chart');

    Route::get('/dashboard/404', function () {
        return view('admin.404');
    })->name('dashboard.404');

    Route::get('/admin/user', [
        UserController::class,
        'index'
    ])->name('admin.user');
    Route::get('/admin/user/{id}', [
        UserController::class,
        'view'
    ])->name('admin.user.view');

    Route::get('/document/index', [
        DocumentController::class,
        'document'
    ])->name('admin.document.index');

    Route::post('/admin-message', [
        DocumentController::class,
        'messageAdmin'
    ])->name('messageAdmin');

    Route::get('/document/view/{id}', [
        DocumentController::class,
        'view'
    ])->name('admin.document.view');

    Route::get('/admin/document/message/{id}', [
        DocumentController::class,
        'message'
    ])->name('admin.document.message');

    Route::get('/admin/area-of-interest', [
        AreaOfInterestController::class,
        'index'
    ])->name('admin.areaofinterest.index');

    Route::get('/admin/area-of-interest/create', [
        AreaOfInterestController::class,
        'create'
    ])->name('admin.areaofinterest.create');

    Route::get('/admin/area-of-interest/update/{id}', [
        AreaOfInterestController::class,
        'update'
    ])->name('admin.areaofinterest.update');

    Route::get('/admin/area-of-interest/view/{id}', [
        AreaOfInterestController::class,
        'view'
    ])->name('admin.areaofinterest.view');

    Route::get('/admin/global-couses', [
        GlobalCoursesController::class,
        'index'
    ])->name('admin.globalcourses.index');

    Route::get('/admin/global-couses/create', [
        GlobalCoursesController::class,
        'create'
    ])->name('admin.globalcourses.create');

    Route::get('/admin/global-couses/update/{id}', [
        GlobalCoursesController::class,
        'update'
    ])->name('admin.globalcourses.update');

    Route::get('/admin/global-couses/view/{id}', [
        GlobalCoursesController::class,
        'view'
    ])->name('admin.globalcourses.view');

    Route::get('/admin/university', [
        UniversityController::class,
        'index'
    ])->name('admin.university.index');

    Route::get('/admin/university/create', [
        UniversityController::class,
        'create'
    ])->name('admin.university.create');

    Route::get('/admin/university/update/{id}', [
        UniversityController::class,
        'update'
    ])->name('admin.university.update');

    Route::get('/admin/university/view/{id}', [
        UniversityController::class,
        'view'
    ])->name('admin.university.view');

    Route::get('/admin/manage-course', [
        CourseController::class,
        'index'
    ])->name('admin.manage.index');

    Route::get('/admin/manage-courses/create', [
        CourseController::class,
        'create'
    ])->name('admin.managecourse.create');

    Route::get('/admin/manage/update/{id}', [
        CourseController::class,
        'update'
    ])->name('admin.manage.update');

    Route::get('/admin/manage/view/{id}', [
        CourseController::class,
        'view'
    ])->name('admin.manage.view');
    
});

Route::get('storage/{key}/{filename}', function ($key, $filename) {
    $path = storage_path('app/public/' . $key . '/' . $filename);

    if (! File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/reset/password/get/{token}', [
    AuthController::class,
    'passwordMail'
])->name('reset.password.get');





route::post('password-change',[
    AuthController::class,
    'changePassword'
])->name('password');
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});