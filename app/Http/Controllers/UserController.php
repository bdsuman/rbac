<?php
namespace App\Http\Controllers;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use App\Mail\SendPasswordMail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    function LoginPage():View{
        return view('auth.pages.login-page');
    }

    function RegistrationPage():View{
        return view('dashboard.pages.registration-page');
    }
    function SendOtpPage():View{
        return view('auth.pages.send-otp-page');
    }
    function SendPasswordPage():View{
        return view('auth.pages.send-password-page');
    }
    function VerifyOTPPage():View{
        return view('auth.pages.verify-otp-page');
    }

    function ResetPasswordPage():View{
        return view('auth.pages.reset-pass-page');
    }





    function UserRegistration(Request $request){
        try {
            $role = Role::find($request->input('role'));
            $user=User::create([
                    'name' => $request->input('name'),
                    'role' =>$role->name,
                    'email' => $request->input('email'),
                    'mobile' => $request->input('mobile'),
                    'password' => Hash::make($request->input('password')),
                ]);

            $user->roles()->attach($role);
            $permit =  $role->permissions()->pluck('id')->toArray();
            $user->permissions()->attach($permit);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ],200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed'
            ],200);

        }
    }

    function UserLogin(Request $request){
        //dd($request->all());

       $data = [
                'email' => $request->email,
                'password' => $request->password
               ];

    if (Auth::attempt($data,true)) {
        $user_type=User::where('email','=',$request->input('email'))->first()->user_type;
        return response()->json([
            'status' => 'success',
            'message' => 'User Login Successful',
            'user_type' => $user_type
        ],200);
        // return redirect()->route('home');
    } else {
        return response()->json([
            'status' => 'failed',
            'message' => 'unauthorized'
        ],200);
        //return redirect()->back();
    }

    }

    function SendPasswordMail(Request $request){

        $email=$request->input('email');
        $new_password=$this->generateUniqueString(8);
        try{
            $count=User::where('email','=',$email)->count();

            if($count==1){
                // OTP Email Address
                Mail::to($email)->send(new SendPasswordMail($new_password));
                // OTO Code Table Update
                 User::where('email','=',$email)->update(['password'=>Hash::make($new_password)]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'New Password has been send to your email !'
                ],200);
            }
            else{
                return response()->json([
                    'status' => 'failed',
                    'message' => 'unauthorized'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => 'failed',
                //'message' => $e->getMessage(),
                'message' => 'Failed Try Again'
            ]);
        }

    }

    function SendOTPCode(Request $request){

        $email=$request->input('email');
        $otp=rand(1000,9999);
        $count=User::where('email','=',$email)->count();

        if($count==1){
            // OTP Email Address
            Mail::to($email)->send(new OTPMail($otp));
            // OTO Code Table Update
            User::where('email','=',$email)->update(['otp'=>$otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 Digit OTP Code has been send to your email !'
            ],200);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }
    function ResetPassword(Request $request){
        try{
            $email=$request->header('email');
            $password=$request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }

    function UserLogout(){
        Auth::logout();
        return redirect()->route('login');
        // return redirect('/userLogin')->cookie('token','',-1);
    }

    public function generateUniqueString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $string;
    }

}
