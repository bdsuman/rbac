<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function permissionPage()
    {
        return view('dashboard.pages.permission-page');
    }

    public function index(){
        return User::where('id','!=',1)->get();
    }
    public function listPermissions(Request $request){
        $id = $request->input('id');
        $role = Role::find($id);
        $role_permit =  $role->permissions()->pluck('id')->toArray();
        $all_permit = Permission::all();
        $new_collection = collect($all_permit)->map(function ($arr) use ($role_permit) {
            $arr['name'] = Str::headline($arr->name);
            if(in_array($arr->id,$role_permit)){
                $arr['checked'] = 'checked';
            }else{
                $arr['checked'] = '';
            }
            return $arr;
        });


        return  $new_collection;

    }
    public function store(Request $request)
    {
        return Permission::create([
            'name'=>$request->input('name'),
        ]);

    }
    public function show(Request $request)
    {
        $id=$request->input('id');
        $user = User::find($id);
        return $user->roles()->pluck('id')->toArray();

    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $role = Role::find($request->input('role'));
        $user = User::find($id);
        $user->update([
            'role' =>$role->name,
        ]);
        $user->roles()->detach();
        $user->roles()->attach($role);
        $permit =  $role->permissions()->pluck('id')->toArray();
        $user->permissions()->detach();
        $user->permissions()->attach($permit);
        return response()->json([
            'status' => 'success',
            'message' => 'User Role Updated Successfully'
        ],200);
    }
    public function destroy(Request $request)
    {
        $id=$request->input('id');
        return User::where('id',$id)->delete();
    }
}
