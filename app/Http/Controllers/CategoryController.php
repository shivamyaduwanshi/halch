<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereNull('deleted_at')->orderBy('id','desc')->paginate('10');
        return view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::whereNull('deleted_at')->orderBy('id','desc')->get();
        return view('category.create',compact('services'));
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
            'title'  => 'required|string|max:255|unique:categories,title,null,id,deleted_at,NULL',
           // 'category_image' => 'required|image|mimes:jpeg,jpg,png,gif'
        ];

        $request->validate($rules);
        $fileName = null;
        if ($request->hasFile('category_image')) {
           $fileName = str_random('10').'.'.time().'.'.request()->category_image->getClientOriginalExtension();
           request()->category_image->move(public_path('images/category/'), $fileName);
         }

        $inserData = [
            'title'  => $input['title']
        ];

        if($fileName){
            $inserData['image'] = $fileName;
        }

        if($request->is_active)
             $inserData['is_active'] = '1';
        else 
            $inserData['is_active']  = '0';
        
            DB::beginTransaction();
        try{
            $Category  = Category::insertGetId($inserData);
            
            if($input['service']){
                $services = array();
                foreach($input['service'] as $key => $value){
                   array_push($services,[
                       'service_id'  => $value,
                       'category_id' => $Category
                   ]);
                }
                DB::table('category_service')->insert($services);
            }
            DB::commit();
            return redirect()->route('index.category')->with('status',true)->with('message',__('Successfully added category'));
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('index.category')->with('status',false)->with('message',__('Failed add category'));
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
       $category = Category::find($id);
       $selectedServices = $category->services;
       if($selectedServices){
           $selectedServices = array_column($category->services->toarray(),'service_id');
       }else{
           $selectedServices = array();
       }
       $services = Service::whereNull('deleted_at')->orderBy('id','desc')->get();
       return view('category.edit',compact('category','services','selectedServices'));
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
            'title'  => 'required|string|max:255|unique:categories,title,'.$id.',id,deleted_at,NULL',
          //  'category_image' => 'mimes:jpeg,jpg,png,gif'
        ];

        $request->validate($rules);
        
        $fileName = null;
        if ($request->hasFile('category_image')) {
           $fileName = str_random('10').'.'.time().'.'.request()->category_image->getClientOriginalExtension();
           request()->category_image->move(public_path('images/category/'), $fileName);
         }
        
        $updateData = [
            'title' => $input['title']
        ];

        if($request->is_active)
            $updateData['is_active'] = '1';
        else
            $updateData['is_active'] = '0';

        if($fileName)
            $updateData['image'] = $fileName;

        DB::beginTransaction();
        try{
            
            DB::table('categories')->where('id',$id)->update($updateData);
            DB::table('category_service')->where('category_id',$id)->delete();

            if($input['service']){
                $services = array();
                foreach($input['service'] as $key => $value){
                   array_push($services,[
                       'service_id'  => $value,
                       'category_id' => $id
                   ]);
                }
                DB::table('category_service')->insert($services);
            }
            DB::commit();
            return redirect()->route('index.category')->with('status',true)->with('message',__('Successfully updated category'));
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('index.category')->with('status',false)->with('message',__('Failed update category'));
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
        $Category = Category::find($request->id);
        $Category->deleted_at = date('Y-m-d H:i:s');
        if($Category->update()){
            return redirect()->route('index.category')->with('status',true)->with('message',__('Successfully deleted category'));
        }else{
            return redirect()->route('index.category')->with('status',false)->with('message',__('Failed delete category'));
        }
            
    }
}
