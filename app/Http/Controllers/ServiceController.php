<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::whereNull('deleted_at')->orderBy('id','desc')->paginate('10');
        return view('service.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = [
            'title'    => 'required',
            // 'service_image' => 'required|image|mimes:jpeg,jpg,png,gif'
        ];

        $request->validate($rules);
        $fileName = null;
        if ($request->hasFile('service_image')) {
           $fileName = str_random('10').'.'.time().'.'.request()->service_image->getClientOriginalExtension();
           request()->service_image->move(public_path('images/service/'), $fileName);
         }

        $inserData = [
            'title'  => $input['title'],
        ];

        if($fileName){
            $inserData['image'] = $fileName;
        }

        if($request->is_active)
             $inserData['is_active'] = '1';
        else 
            $inserData['is_active']  = '0';

        $service  = Service::insertGetId($inserData);

        if($service){
            return redirect()->route('index.service')->with('status',true)->with('message','Successfully added service');
        }else{
            return redirect()->route('index.service')->with('status',false)->with('message','Failed add service');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $service = Service::find($id);
       return view('service.edit',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rules = [
            'title'    => 'required',
          //  'service_image' => 'mimes:jpeg,jpg,png,gif'
        ];

        $request->validate($rules);
        
        $fileName = null;
        if ($request->hasFile('service_image')) {
           $fileName = str_random('10').'.'.time().'.'.request()->service_image->getClientOriginalExtension();
           request()->service_image->move(public_path('images/service/'), $fileName);
         }

        $Service  = Service::find($id);
        $Service->title = $request->title;
        
        if($request->is_active)
             $Service->is_active = '1';
        else 
            $Service->is_active  = '0';

        if($fileName)
          $Service->image = $fileName;

        if($Service->update()){
            return redirect()->route('index.service')->with('status',true)->with('message','Successfully updated service');
        }else{
            return redirect()->route('index.service')->with('status',false)->with('message','Failed update service');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $Service = Service::find($request->id);
        $Service->deleted_at = date('Y-m-d H:i:s');
        if($Service->update()){
            return redirect()->route('index.service')->with('status',true)->with('message','Successfully deleted service');
        }else{
            return redirect()->route('index.service')->with('status',false)->with('message','Failed delete service');
        }
            
    }
}
