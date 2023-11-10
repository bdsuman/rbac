<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class EventController extends Controller
{
    function EventPage(){
        $categories = Category::select('id','name')->orderBy('name', 'asc')->get();
        return view('backend.pages.dashboard.event-page',compact('categories'));
    }

    function EventList(Request $request){
        $user_id=auth()->id();
        return Event::with('category')->where('user_id',$user_id)->get();
    }

    function EventCreate(Request $request){
        $user_id=auth()->id();
        // Prepare File Name & Path
        $img=$request->file('image');

        $t=time();
        $file_name=$img->getClientOriginalName();
        $file_ext=$img->getClientOriginalExtension();
        $img_name="{$user_id}-{$t}.{$file_ext}";
        $img_url="uploads/{$img_name}";

        // Upload File
        $img->move(public_path('uploads'),$img_name);
        return Event::create([
            'image'=> $img_url,
            'type'=>$request->input('type'),
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'date'=>$request->input('date'),
            'time'=>$request->input('time'),
            'location'=>$request->input('location'),
            'user_id'=>$user_id,
            'categorie_id'=>$request->input('categorie_id')
        ]);
    }

    function EventDelete(Request $request){
        $event_id=$request->input('id');
        $user_id=auth()->id();
        $filePath=$request->input('oldImage');
        File::delete($filePath);
        return Event::where('id',$event_id)->where('user_id',$user_id)->delete();
    }


    function EventByID(Request $request){
        $event_id=$request->input('id');
        $user_id=auth()->id();;
        return Event::where('id',$event_id)->where('user_id',$user_id)->first();
    }



    function EventUpdate(Request $request){
        $event_id=$request->input('id');
        $user_id=auth()->id();
        if ($request->hasFile('image')) {
             // Upload New File
             $img=$request->file('image');
             $t=time();
             $file_name=$img->getClientOriginalName();
             $file_ext=$img->getClientOriginalExtension();
             $img_name="{$user_id}-{$t}.{$file_ext}";
             $img_url="uploads/{$img_name}";
             $img->move(public_path('uploads'),$img_name);
 
             // Delete Old File
             $filePath=$request->input('oldImage');
             File::delete($filePath);
           
        }else{
            $img_url = $request->input('oldImage');
        }
        return Event::where('id',$event_id)->where('user_id',$user_id)->update([
            'image'=> $img_url,
            'type'=>$request->input('type'),
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'date'=>$request->input('date'),
            'time'=>$request->input('time'),
            'location'=>$request->input('location'),
            'user_id'=>$user_id,
            'categorie_id'=>$request->input('categorie_id')
        ]);
       
    }
}
