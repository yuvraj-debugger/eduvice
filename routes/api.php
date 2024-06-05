<?php
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EducationController;
use App\Http\Controllers\API\UniversityController;
use App\Http\Controllers\API\AreaOfInterestController;
use App\Http\Controllers\API\GlobalCourseController;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 */
Route::post('login', [
    AuthController::class,
    'signin'
]);
Route::post('signemail', [
    AuthController::class,
    'signemail'
]);

Route::post('register', [
    AuthController::class,
    'signup'
]);

Route::post('/forget_password', [
    AuthController::class,
    'forgetPassword'
]);

Route::post('/reset_password', [
    AuthController::class,
    'resetPassword'
]);

Route::get('/state/{country_id}', [
    AddressController::class,
    'state'
]);

Route::get('/city/{state}/{country_id}', [
    AddressController::class,
    'city'
]);
Route::get('verify-email/{token}', [
    AuthController::class,
    'userVerify'
])->name('verify');

Route::group([
    'middleware' => [
        'auth:sanctum'
    ]
], function () {
    Route::get('/user_details', [
        AuthController::class,
        'userDetails'
    ]);

    Route::get('/area_interest', [
        AreaOfInterestController::class,
        'areaInterest'
    ]);

    Route::get('/logout', [
        AuthController::class,
        'logout'
    ]);

    Route::post('/change_password', [
        AuthController::class,
        'updatePassword'
    ]);

    Route::post('/education_detail', [
        EducationController::class,
        'educationDetail'
    ]);

    Route::post('/upload_profile_photo', [
        AuthController::class,
        'uploadprofilephoto'
    ]);

    Route::get('/country', [
        AddressController::class,
        'country'
    ]);
    Route::post('/profile_update', [
        AuthController::class,
        'profileUpdate'
    ]);
    Route::post('/addEducation', [
        AuthController::class,
        'addEducation'
    ]);

    Route::post('/updateEducation/{id}', [
        AuthController::class,
        'updateEducation'
    ]);

    Route::post('/addTestScore', [
        AuthController::class,
        'addTestScore'
    ]);

    Route::post('/updateTestScore', [
        AuthController::class,
        'updateTestScore'
    ]);
    Route::post('/updatePreferences', [
        AuthController::class,
        'updatePreference'
    ]);
    Route::any('/uploadDocument', [
        AuthController::class,
        'uploadDocument'
    ]);

    Route::get('/myapplication', [
        AuthController::class,
        'myApplication'
    ]);

    Route::post('/message/{document_id}', [
        AuthController::class,
        'message'
    ]);
    Route::get('/preferred_search', [
        AuthController::class,
        'preferred_search'
    ]);
    Route::get('/preference_details', [
        AuthController::class,
        'preferenceDetails'
    ]);
    route::post('/update_all_education', [
        AuthController::class,
        'updateAllEducation'
    ]);
    route::post('/add_test_score_ielts', [
        AuthController::class,
        'addIelts'
    ]);

    Route::get('/global_course', [
        GlobalCourseController::class,
        'globalCourse'
    ]);
    Route::post('/account_setting', [
        AuthController::class,
        'accountSetting'
    ]);

    Route::get('/universityDetail', [
        UniversityController::class,
        'getUniversity'
    ]);

    Route::post('/search-university', [
        UniversityController::class,
        'searchUniversity'
    ]);
    Route::post('/search', [
        UniversityController::class,
        'search'
    ]);
    Route::post('/university-data', [
        UniversityController::class,
        'univerisityData'
    ]);
    Route::get('/master-data', [
        AuthController::class,
        'masterData'
    ]);
    Route::get('/graduation-data', [
        AuthController::class,
        'graduationData'
    ]);
    Route::any('/all-document', [
        AuthController::class,
        'allDocument'
    ]);
    Route::post('/all-city', [
        AuthController::class,
        'allCity'
    ]);
    Route::get('/budget', [
        AuthController::class,
        'budget'
    ]);
    Route::get('/university_search', [
        AuthController::class,
        'university_search'
    ]);
    Route::post('/university_course', [
        AuthController::class,
        'universityCourse'
    ]);
    
    Route::get('/user/delete',[AuthController::class,'destroy'])->name('user.delete');
});
