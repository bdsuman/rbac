<?php


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Web API Routes

Route::get('/',function(){
    return redirect()->route('login');
});
// Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/send-password',[UserController::class,'SendPasswordMail']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);

// Page Routes
Route::get('/userLogin',[UserController::class,'LoginPage'])->name('login');
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/sendPassword',[UserController::class,'SendPasswordPage']);

Route::group(['prefix' => '', 'middleware' => ['auth']], function () {

    Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])->name('home');
    Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage']);
    Route::get('/userProfile', [DashboardController::class, 'ProfilePage']);
    // User Logout
    Route::get('/logout', [UserController::class, 'UserLogout']);
    Route::get('/categoryPage', [CategoryController::class, 'CategoryPage']);
    Route::get('/eventPage', [EventController::class, 'EventPage']);
    Route::get('/reportPage', [ReportController::class, 'index']);


    Route::post('/reset-password', [UserController::class, 'ResetPassword']);
    Route::get('/user-profile', [DashboardController::class, 'UserProfile']);
    Route::post('/user-update', [DashboardController::class, 'UpdateProfile']);
    Route::post('/user-pass-update', [DashboardController::class, 'UpdatePassword']);

    // Category API
    Route::post("/create-category", [CategoryController::class, 'CategoryCreate']);
    Route::get("/list-category", [CategoryController::class, 'CategoryList']);
    Route::post("/delete-category", [CategoryController::class, 'CategoryDelete']);
    Route::post("/update-category", [CategoryController::class, 'CategoryUpdate']);
    Route::post("/category-by-id", [CategoryController::class, 'CategoryByID']);

    // Event API
    Route::post("/create-event", [EventController::class, 'EventCreate']);
    Route::get("/list-event", [EventController::class, 'EventList']);
    Route::post("/delete-event", [EventController::class, 'EventDelete']);
    Route::post("/update-event", [EventController::class, 'EventUpdate']);
    Route::post("/event-by-id", [EventController::class, 'EventByID']);

});
