<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PermissionController extends Controller
{
    public function permissionPage()
    {
        return view('dashboard.pages.permission-page');
    }

    public function index(){
        return User::all();
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
        return User::where('id',$id)->first();
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
        return Permission::where('id',$id)->delete();
    }
}
