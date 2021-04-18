<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Exports\MembershipPlanExport;
use Maatwebsite\Excel\Facades\Excel;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['memberships'] = Membership::whereNull('deleted_at')->orderBy('id','asc')->paginate();
       return view('membership_plan.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['membership'] = Membership::find($id);
        return view('membership_plan.edit',compact('data'));
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
          'title'     => 'required',
          'sub_title' => 'required',
          'price'     => 'required',
          'recruit_rm_bonus_amount' => 'required',
          'first_generation' => 'required',
          'second_generation' => 'required',
          'third_generation' => 'required',
        ];

        $request->validate($rules);

        $Membership  = Membership::find($id);
        $Membership->title = $input['title'];
        $Membership->sub_title = $input['sub_title'];
        $Membership->price = $input['price'];
        $Membership->recruit_rm_bonus_amount = $input['recruit_rm_bonus_amount'];
        $Membership->first_generation = $input['first_generation'];
        $Membership->second_generation = $input['second_generation'];
        $Membership->third_generation = $input['third_generation'];
        
        if($request->is_active)
             $Membership->is_active = '1';
        else 
            $Membership->is_active  = '0';

        if($Membership->update()){
            return redirect()->route('index.membership')->with('status',true)->with('message','Successfully updated membership plan');
        }else{
            return redirect()->route('index.membership')->with('status',false)->with('message','Failed update membership plan');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $data = Membership::whereNull('deleted_at')->orderBy('id','asc')->get();
        if($data->toarray())
           return Excel::download(new MembershipPlanExport($data), 'membershipplan'.date('Y-m-d').'.xlsx');
        else
           return back()->with('status',false)->with('message','Record Not found');
    }

}
