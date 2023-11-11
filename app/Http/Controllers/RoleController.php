<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function rolePage()
    {
        return view('dashboard.pages.role-page');
    }

    public function index(){
        return Role::where('id','!=',1)->get();
    }
    public function store(Request $request)
    {

        $role = new Role();
        $role->name = $request->input('name');
        $role->save();
        $role->permissions()->attach($request->input('permissions'));
        return response()->json([

        ],201);

    }
    public function show(Request $request)
    {
        $id=$request->input('id');
        return Role::where('id',$id)->first();
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $id = $request->input('id');
        $role = Role::find($id);
        $role->update([
                'name'=>$request->input('name'),
            ]);
        $role->permissions()->detach();
        $role->permissions()->attach($request->input('permissions'));

        return response()->json([

        ],200);

    }
    public function destroy(Request $request)
    {
        $id=$request->input('id');
        return Role::where('id',$id)->delete();
    }

}
