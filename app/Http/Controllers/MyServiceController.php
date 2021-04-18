<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\VendorService;
use Auth;

class MyServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = VendorService::where('vendor_id',auth::id())->whereNull('deleted_at')->orderBy('id','desc')->paginate('10');
        return view('myservice.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('myservice.create');
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
            'category'     => 'required',
            'service'      => 'required',
            'service_cost' => 'required',
        ];

        $request->validate($rules);

        $Service  = new VendorService;
        $Service->service_id   = $request->service;
        $Service->service_cost = $request->service_cost;
        $Service->vendor_id    = \auth::id();
        
        if($request->is_active)
             $Service->is_active = '1';
        else 
            $Service->is_active  = '0';

        if($Service->save()){
            return redirect()->route('index.myservice')->with('status',true)->with('message',__('Successfully added service'));
        }else{
            return redirect()->route('index.myservice')->with('status',false)->with('message',__('Failed add service'));
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
       $service = VendorService::find($id);
       return view('myservice.edit',compact('service'));
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
            'category'     => 'required',
            'service'      => 'required',
            'service_cost' => 'required',
        ];

        $request->validate($rules);

        $Service  = VendorService::find($id);
        $Service->service_id   = $request->service;
        $Service->service_cost = $request->service_cost;
        
        if($request->is_active)
             $Service->is_active = '1';
        else 
            $Service->is_active  = '0';

        if($Service->update()){
            return redirect()->route('index.myservice')->with('status',true)->with('message',__('Successfully updated service'));
        }else{
            return redirect()->route('index.myservice')->with('status',false)->with('message',__('Failed update service'));
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
        $Service = VendorService::find($request->id);
        $Service->deleted_at = date('Y-m-d H:i:s');
        if($Service->update()){
            return redirect()->route('index.myservice')->with('status',true)->with('message',__('Successfully deleted service'));
        }else{
            return redirect()->route('index.myservice')->with('status',false)->with('message',__('Failed delete service'));
        }
            
    }

    public function getServices(Request $request){
        $vendorId = \Auth::id();
        $selectedServices = \DB::table('vendor_services')->select('service_id')->where(function($query) use($request){
            if($request->service_id){
                $query->where('service_id','!=',$request->service_id);
            }
        })->where('vendor_id',$vendorId)->whereNull('deleted_at')->get();
        $selectedIds  = array_column($selectedServices->toarray(),'service_id');
        $services = \App\Models\CategoryService::whereNotIn('service_id',$selectedIds)->get();
        if($services->toarray()){
            $data = array();
            foreach($services as $key => $value){
              array_push($data,[
                  'category_id' => $value->category_id,
                  'service_id'  => $value->service_id,
                  'image'       => $value->service->image,
                  'service'     => $value->service->title,
                  'category'    => $value->category->title,
                  'total_vendors'  => $value->service->totalVendors($value->service_id)
              ]);
            }
            return ['status'=>true,'message'=>__('Record found'),'data'=>$data];
        }else{
            return ['status'=>false,'message'=>__('Record not found')];
        }
    }
}
