<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helper\Helper;
use App\Models\Event;
use App\Models\Registration;

class ReportController extends Controller
{

    function index(Request $request){
      
        $status='';
        $from = $request->fromDate;
        $to = $request->toDate;
        $event_id = $request->event_id;
        $check=0;
           
        
        $user_id=auth()->id();
        $registrations=Registration::with('event')->where('user_id',$user_id);
        if(!empty($event_id)){
            $check=1;
            $event = Event::find($event_id);
            $registrations->where('event_id',$event_id);
           
            $status=$status.'Event : '. $event->name;
        }
            /**
             * Only To date search
             */
        if(!empty($to) && empty($from)){  
            $registrations->where('date','<=',$to);
            
            $status=$status.' To Date: '.Helper::dateCheck($to);
        }
            /**
             * Only From date search
             */     
        if(empty($to) && !empty($from)){  
            $registrations->where('date','>=',$from);
            $status=$status.' From Date: '.Helper::dateCheck($from);
        }
            /**
             * To & From date search
             */
            if(!empty($to) && !empty($from)){  
                $registrations->where('date','>=',$from)->where('date','<=',$to);
             
                    if($from==$to){
                        $status=$status.' Date: '.Helper::dateCheck($from);
                    }else{
                        $status=$status.' Date: '.Helper::dateCheck($from).' - '.Helper::dateCheck($to);
                    }
            }
            /**
             * All Blank Only Today Data
             */
            $date = date('Y-m-d');
            if(empty($to) && empty($from) && $check==0){  
                $registrations->where('date',$date);
              
                $status=$status.' Today : '.Helper::dateCheck($date);
            }
        $registrations=$registrations->get();
       
        $events= Event::where('user_id',$user_id)->get();
        return view('backend.pages.dashboard.report-page',compact('events','registrations','status'));
    }

}
