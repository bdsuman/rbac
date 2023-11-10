<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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