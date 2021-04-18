<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Auth;

class BookingController extends Controller
{
    public function index(Request $request){
        $bookings = Booking::where(function($query) use ($request) {
           if(auth::user()->role_id != '1'){
                $query->where('vendor_id',auth::id());
                $currentdate = date('Y-m-d',strtotime(date('Y-m-d') . '+3 days'));
               if(!auth::user()->isPlanActive){
                $query->whereDate('created_at','<',$currentdate);  
               }
           }
        })->orderBy('id','desc')->paginate('10');
        if(auth::user()->role_id == '1')
        return view('booking.admin_index',compact('bookings'));
        else
        return view('booking.index',compact('bookings'));
    }

    public function show($id){
        $booking = Booking::find($id);
        if(auth::user()->role_id == '1')
            return view('booking.admin_show',compact('booking'));
        else
           return view('booking.show',compact('booking'));
    }
}
