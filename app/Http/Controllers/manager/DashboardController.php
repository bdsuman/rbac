<?php

namespace App\Http\Controllers\Manager;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    function DashboardPage():View{
        return view('dashboard.manager.pages.dashboard-page');
    }

    function ProfilePage():View{
        return view('dashboard.manager.pages.profile-page');
    }
    
    function UserProfile(){
            $user=User::find(auth()->id());
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
                'data' => $user
            ],200);
        }

        function UpdateProfile(Request $request){
            try{
                $name=$request->input('name');
                $mobile=$request->input('mobile');
                User::find(auth()->user()->id)->update([
                    'name'=>$name,
                    'mobile'=>$mobile
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Request Successful',
                ],200);
    
            }catch (\Exception $exception){
                return response()->json([
                    'status' => 'fail',
                    // 'message' => 'Something Went Wrong',
                    'message' => $exception->getMessage(),
                ],200);
            }
        }

        function UpdatePassword(Request $request){
            try{
                $user=User::find(auth()->user()->id);
                $old_password=$request->input('old_password');
                $new_password=$request->input('new_password');

                if (!$user) {
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'User Not Found.',
                    ],200);
                }
                if (!Hash::check($old_password, $user->password)) {
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Old Password Not Match.',
                    ],200);
                }
                $password=Hash::make($new_password);
                $user->update([
                    'password'=>$password
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Request Successful',
                ],200);
    
            }catch (\Exception $exception){
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Something Went Wrong',
                ],200);
            }
        }
}
