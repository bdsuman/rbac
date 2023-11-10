<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function permissionPage()
    {
        return view('dashboard.pages.permission-page');
    }

    public function index(){
        return Permission::all();
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
        return Permission::where('id',$id)->first();
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        return Permission::where('id', $id)->update([
            'name'=>$request->input('name'),
        ]);

    }
    public function destroy(Request $request)
    {
        $id=$request->input('id');
        return Permission::where('id',$id)->delete();
    }
}
