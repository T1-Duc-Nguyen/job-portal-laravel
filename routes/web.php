<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\JobTypeController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Candidate\CompanyControllerr;
use App\Http\Controllers\Candidate\CVController;
use App\Http\Controllers\Candidate\ProfileController;
use App\Http\Controllers\Candidate\SavedJobController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Employer\CompanyController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;


Route::get(
    '/candidate/companies',
    [CompanyControllerr::class, 'index']
);

Route::get(
    '/candidate/companies/{slug}',
    [CompanyControllerr::class, 'show']
)->name('company.show');

Route::get(
    '/employer/company/{slug}',
    [CompanyController::class, 'show']
)->name('company.show');

Route::post(
    '/jobs/{jobId}/apply',
    [ApplicationController::class, 'apply']
)->middleware('auth');

Route::middleware(['auth'])->group(function () {

    Route::post('/jobs/{id}/save',
        [SavedJobController::class, 'save']
    );

    Route::post('/jobs/{id}/unsave',
        [SavedJobController::class, 'unsave']
    );

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    );

    Route::post(
        '/notifications/{id}/read',
        [NotificationController::class, 'read']
    );
    Route::get(
        '/chat',
        [ChatController::class, 'index']
    );

    Route::get(
        '/chat/start/{id}',
        [ChatController::class, 'start']
    );

    Route::get(
        '/chat/messages/{id}',
        [ChatController::class, 'messages']
    );
    Route::get(
        '/chat/{userId}',
        [ChatController::class, 'open']
    );
    Route::post(
        '/chat/send',
        [ChatController::class, 'send']
    );
    Route::delete('/chat/delete/{id}', [
        ChatController::class,
        'deleteConversation',
    ]);

});

// HOME
Route::get('/',
    [HomeController::class, 'index']
);

// JOB LIST
Route::get('/jobs',
    [HomeController::class, 'jobs']
);

// JOB DETAIL
Route::get('/jobs/{slug}',
    [HomeController::class, 'detail']
);
// HOME
/*
Route::get('/', function () {
    return redirect('/login');
});
*/

// ================= AUTH =================

// LOGIN
Route::get('/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post('/login',
    [AuthController::class, 'login']
);

// REGISTER
Route::get('/register',
    [AuthController::class, 'showRegister']
)->name('register');

Route::post('/register',
    [AuthController::class, 'register']
);

// LOGOUT
Route::post('/logout',
    [AuthController::class, 'logout']
);

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/login',
    [AdminAuthController::class, 'showLogin']
)->name('admin.login');

Route::post(
    '/admin/login',
    [AdminAuthController::class, 'login']
);

Route::post(
    '/admin/logout',
    [AdminAuthController::class, 'logout']
);

// ================= ADMIN =================

Route::prefix('admin')
    ->middleware(['admin'])
    ->group(function () {

        Route::get('/',
            [AdminController::class, 'dashboard']
        );
        Route::get(
            '/applications',
            [App\Http\Controllers\Admin\ApplicationController::class, 'index']
        );
        Route::resource('users',
            UserController::class
        );
        Route::resource(
            'employers',
            App\Http\Controllers\Admin\EmployerController::class
        );

        Route::get(
            '/employers/{id}/approve',
            [App\Http\Controllers\Admin\EmployerController::class, 'approve']
        );

        Route::get(
            '/employers/{id}/reject',
            [App\Http\Controllers\Admin\EmployerController::class, 'reject']
        );
        // JOBS
        Route::resource(
            'jobs',
            JobController::class
        );

        // APPROVE JOB
        Route::get(
            '/jobs/{id}/approve',
            [JobController::class, 'approve']
        );

        // REJECT JOB
        Route::get(
            '/jobs/{id}/reject',
            [JobController::class, 'reject']
        );
        Route::post(
            '/jobs/{id}/reject',
            [JobController::class, 'reject']
        );

        // CATEGORIES
        Route::resource(
            'categories',
            CategoryController::class
        );
        // LOCATIONS
        Route::resource(
            'locations',
            LocationController::class
        );
        // JOB TYPES
        Route::resource(
            'jobtypes',
            JobTypeController::class
        );
        Route::resource(
            'skills',
            SkillController::class
        );
        Route::get(
            '/profile/password',
            [ProfileController::class, 'password']
        );

        Route::post(
            '/profile/password',
            [ProfileController::class, 'updatePassword']
        );
    });

// ================= CANDIDATE =================

Route::prefix('candidate')
    ->middleware(['auth', 'candidate'])
    ->group(function () {

        // DASHBOARD
        Route::get(
            '/dashboard',
            [CandidateController::class, 'dashboard']
        );

        // APPLY
        Route::post(
            '/jobs/{jobId}/apply',
            [ApplicationController::class, 'apply']
        )->middleware('auth');

        // MY APPLICATIONS
        Route::get(
            '/applications',
            [ApplicationController::class, 'myApplications']
        );

        // SAVED JOBS
        Route::get(
            '/saved-jobs',
            [SavedJobController::class, 'index']
        );

        /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

        Route::get(
            '/profile',
            [ProfileController::class, 'index']
        );

        Route::post(
            '/profile/update',
            [ProfileController::class, 'update']
        );
        Route::get(
            '/profile/edit',
            [ProfileController::class, 'edit']
        );
        Route::get(
            '/profile/password',
            [ProfileController::class, 'password']
        );

        Route::post(
            '/profile/password',
            [ProfileController::class, 'updatePassword']
        );

        /*
        |--------------------------------------------------------------------------
        | CV
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/cv/upload',
            [CVController::class, 'upload']
        );

        Route::delete(
            '/cv/{id}',
            [CVController::class, 'destroy']
        );
        Route::post(

            '/cv/upload-normal',

            [CVController::class, 'uploadNormal']

        );
        Route::post(

            '/application/{id}/reupload-cv',

            [CVController::class, 'reuploadApplicationCv']

        );

    });

// ================= EMPLOYER =================

Route::prefix('employer')
    ->middleware(['auth', 'employer'])
    ->group(function () {

        Route::get('/dashboard',
            [EmployerController::class, 'dashboard']
        );
        // EMPLOYER JOBS
        Route::resource(
            'jobs',
            App\Http\Controllers\Employer\JobController::class
        );
        Route::get(
            '/applications',
            [ApplicationController::class, 'employerApplications']
        );
        // JOB APPLICATIONS
        Route::get(
            '/jobs/{jobId}/applications',
            [ApplicationController::class, 'jobApplications']
        )->middleware('auth');

        Route::post(
            '/applications/{id}/reviewing',
            [ApplicationController::class, 'reviewing']
        )->middleware('auth');

        Route::post(
            '/applications/{id}/approve',
            [ApplicationController::class, 'approve']
        )->middleware('auth');

        Route::post(
            '/applications/{id}/reject',
            [ApplicationController::class, 'reject']
        )->middleware('auth');

        Route::get(
            '/company',
            [CompanyController::class, 'index']
        );

        Route::post(
            '/company/update',
            [CompanyController::class, 'update']
        );
        Route::get(
            '/profile/password',
            [ProfileController::class, 'password']
        );

        Route::post(
            '/profile/password',
            [ProfileController::class, 'updatePassword']
        );
    });
