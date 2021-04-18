<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Auth\Passwords\PasswordBroker;
use App\User;
use Auth;
use Validator;
use DB;

class AuthController extends Controller
{

    /**
    * End Point  :- user/login
    * Method     :- Post
    * Parameters :- rut_number,password,device_type
    * Optional Parameter :- device_token,lat,lng
    */
    public function login(Request $request){

        $input = $request->all();

        $rules = [
          'email'         => 'required',
          'password'      => 'required',
          'device_type'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules );

        if ($validator->fails()) {
            $errors =  $validator->errors()->all();
            return response(['status' => false , 'message' => $errors[0]]);              
        }

         if(!auth()->guard()->attempt(array( 'email' => $input['email'] , 'password' => $input['password'] , 'role_id' => '3'  , 'deleted_at' => NULL ))) {
            return response(['status' => false , 'message' => __('Invalid credientials') ]);       
         } 
        
         $User = User::find(auth()->guard()->id());

         auth::logout();

         if($User->is_active != '1'){
            return response(['status'=>false , 'message'=>__('Your are inactive , Please contact with your administrator')]);
         }

         $User->device_type  = $input['device_type']  ?? NULL;
         $User->device_token = $input['device_token'] ?? NULL;
         $User->update();

         $data['user_id']           = $User->id;
         $data['name']              = $User->name       ?? '';
         $data['profile_image']     = $User->profile_image;
         $data['email']             = $User->email      ?? '';
         $data['phone']             = $User->phone      ?? '';
         $data['address']           = $User->address    ?? '';

        return response(['status' => true , 'message' => __('Successfully logged In') , 'data' => $data ]);
    }

    /**
    * End Point  :- user/social/login
    * Method     :- Post
    * Parameters :- rut_number,password,device_type
    * Optional Parameter :- device_token,lat,lng
    */
    public function socialLogin(Request $request){
      
      $input = $request->all();

      $rules = [
        'social_id'     => 'required',
        'login_type'    => 'required',
      ];

      $validator = Validator::make($request->all(), $rules );

      if ($validator->fails()) {
          $errors =  $validator->errors()->all();
          return response(['status' => false , 'message' => $errors[0]]);              
      }
      
      $User = User::where('social_id',$input['social_id'])->whereNull('deleted_at')->first();

      if(is_null($User) || empty($User)){
          $insertData['social_id'] = $input['social_id'];
          $insertData['name']      = $input['name'];
          $insertData['phone']     = $input['phone'];
          $insertData['email']     = $input['email'];
          try{
            $insertId = \DB::table('users')->insertGetId($insertData);
            $User = User::where('id',$insertId)->first();
          }catch(\Exception $e){
            return ['status'=>false,'message'=>__('Failed to login')];
          }
      }

       if($User->is_active != '1'){
          return response(['status'=>false , 'message'=>__('Your are inactive , Please contact with your administrator')]);
       }

       $User->device_type  = $input['device_type']  ?? NULL;
       $User->device_token = $input['device_token'] ?? NULL;
       $User->email        = $input['email']        ?? NULL;
       $User->phone        = $input['phone']        ?? NULL;
       $User->update();

       $data['user_id']           = $User->id;
       $data['name']              = $User->name       ?? '';
       $data['profile_image']     = $User->profile_image;
       $data['email']             = $User->email      ?? '';
       $data['phone']             = $User->phone      ?? '';
       $data['address']           = $User->address    ?? '';

      return response(['status' => true , 'message' => __('Successfully logged In') , 'data' => $data ]);
    }

    /**
    * End Point  :- user/signup
    * Method     :- Post
    * Parameters :- rut_number, password, confirm_password, device_type
    *      device_token, lat,lng
    */
    public function signup(Request $request){

        $input = $request->all();

        $rules = [
          'name'          => 'required',
          'email'         => 'required|unique:users,email,null,id,deleted_at,NULL',
          'password'      => 'required',
          'confirm_password' => 'required',
          'device_type'   => 'required',
        ];

      if(isset($input['phone']) && !empty($input['phone']))
          $rules['phone'] = 'unique:users,phone,null,id,deleted_at,NULL';
        
        $validator = Validator::make($request->all(), $rules );

        if ($validator->fails()) {
            $errors =  $validator->errors()->all();
            return response(['status' => false , 'message' => $errors[0]]);              
        }

        $storeData = [
           'name'          => $input['name'],
           'email'         => $input['email'],
           'phone'         => $input['phone'] ?? null,
           'password'      => \Hash::make($input['password']),
           'device_type'   => $input['device_type'],
           'device_token'  => $input['device_token'] ?? Null,
           'lat'           => $input['lat']  ?? NULL,
           'lng'           => $input['lng'] ?? Null,
           'role_id'       => '3'
        ];
        
        $insertId = User::insertGetId($storeData);

        if($insertId){
          $user = User::find($insertId);
          $storeData['user_id'] = $user->id;
          $storeData['profile_image'] = $user->profile_image;
          unset($storeData['password']);
          return ['status'=>true,'message'=>__('Successfully signed up'),'data'=>$storeData];
        }else{
          return ['status'=>false,'message'=>__('Failed to sign up')];
        }

    }

    /**
    * End Point  :- user/get/profile
    * Method     :- Get
    * Parameters :- user_id
    */
    public function getProfile(Request $request){

      $input = $request->all();

      $rules = [
        'user_id' => 'required',
      ];

      $validator = Validator::make($request->all(), $rules );

      if ($validator->fails()) {
          $errors =  $validator->errors()->all();
          return response(['status' => false , 'message' => $errors[0]]);              
      }

      $isUserExist = $this->isUserExist($input['user_id']);

      if(!$isUserExist)
           return response(['status'=>false,'message'=>__('This user does not exist')],401);

       $User = User::find($input['user_id']);

       if($User->is_active != '1'){
          return response(['status'=>false , 'message'=>__('Your are inactive , Please contact with your administrator')],401);
       }

       $data['user_id']           = $User->id;
       $data['profile_image']     = $User->profile_image;
       $data['name']              = $User->name       ?? '';
       $data['email']             = $User->email      ?? '';
       $data['phone']             = $User->phone      ?? '';
       $data['address']           = $User->address    ?? '';

      return response(['status' => true , 'message' => __('Record found') , 'data' => $data ]);
    }

     /**
    * End Point  :- user/update/profile
    * Method     :- Post
    * Parameters :- user_id,phone, name, email, address
    *                , profile_image (Optional)
    */
    public function updateProfile(Request $request){

      $input = $request->all();

      $UserId     = $input['user_id'] ?? NULL;

      $rules = [
        'name'          => 'required',
      ];

      if(isset($input['phone']) && !empty($input['phone']))
         $rules['phone'] = 'unique:users,phone,'.$UserId.',id,deleted_at,NULL';

      if(isset($input['email']) && !empty($input['email']))
          $rules['email'] = 'unique:users,email,'.$UserId.',id,deleted_at,NULL';

      $validator = Validator::make($request->all(), $rules );

      if ($validator->fails()) {
          $errors =  $validator->errors()->all();
          return response(['status' => false , 'message' => $errors[0]]);              
      }

      $isUserExist = $this->isUserExist($input['user_id']);

      if(!$isUserExist)
           return response(['status'=>false,'message'=>__('This user does not exist')],401);

       $User = User::find($input['user_id']);

       if($User->is_active != '1'){
          return response(['status'=>false , 'message'=>__('Your are inactive , Please contact with your administrator')],401);
       }

       $fileName = null;
       if ($request->hasFile('profile_image')) {
          $fileName = str_random('10').'.'.time().'.'.request()->profile_image->getClientOriginalExtension();
          request()->profile_image->move(public_path('images/profile/'), $fileName);
        }
      $updateData = [
         'phone'         => $input['phone']   ?? NULL,
         'name'          => $input['name']    ?? NULL,
         'email'         => $input['email']   ?? NULL,
         'address'       => $input['address'] ?? NULL,
        ];

        if($fileName)
           $updateData['profile_image'] = $fileName;
      
      $User = User::where('id',$UserId)->update($updateData);

      return ['status'=>true,'message'=>__('Successfully updated')];

      if($User)
        return ['status'=>true,'message'=>__('Successfully updated')];
      else
        return ['status'=>false,'message'=>__('Failed to update')];
    }

     /**
    * End Point  :- user/change/password
    * Method     :- Post
    * Parameters :- user_id, old_password, new_password
    *
    */
    public function changePassword(Request $request){
        
      $input    = $request->all();

      $rules = [
                'user_id'           => 'required',
                'old_password'      => 'required',
                'new_password'      => 'min:6|required',
               ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        $errors =  $validator->errors()->all();
        return response(['status' => false , 'message' => $errors[0]] , 200);              
      }

      $isUserExist = $this->isUserExist($input['user_id']);

      if(!$isUserExist)
           return response(['status'=>false,'message'=>__('This user does not exist')],401);

       $User = User::find($input['user_id']);

       if($User->is_active != '1'){
          return response(['status'=>false , 'message'=>__('Your are inactive , Please contact with your administrator')],401);
       }

       if (!(\Hash::check($request->old_password,  $User->password))) {
            return ['status' => false , 'message' => __('Your old password does not matches with the current password  , Please try again')];
       }

       elseif(strcmp($request->old_password, $request->new_password) == 0){
            return ['status' => false , 'message' => __('New password cannot be same as your current password,Please choose a different new password')];
       }

        $User->password = \Hash::make($input['new_password']);
        if($User->update()){
         return response(['status' => true , 'message' => __('Successfully updated')] , 200);
        }
        return response(['status' => false , 'message' => __('Failed to update')] , 200);
    }

    /**
    * End Point  :- user/update/current/location
    * Method     :- Post
    * Parameters :- user_id, lat, lng
    *
    */
    public function updateCurrentLocation(Request $request){
      $input = $request->all();

      $UserId     = $input['user_id'] ?? NULL;

      $rules = [
        'user_id'  => 'required',
        'lat'      => 'required',
        'lng'      => 'required',
      ];

      $validator = Validator::make($request->all(), $rules );

      if ($validator->fails()) {
          $errors =  $validator->errors()->all();
          return response(['status' => false , 'message' => $errors[0]]);              
      }

      $isUserExist = $this->isUserExist($input['user_id']);

      if(!$isUserExist)
           return response(['status'=>false,'message'=>__('This user does not exist')],401);

       $User = User::find($input['user_id']);

       if($User->is_active != '1'){
          return response(['status'=>false , 'message'=>__('Your are inactive , Please contact with your administrator')],401);
       }

      $updateData = [
         'lat'  => $input['lat'],
         'lng'  => $input['lng']
        ];

      $User = User::where('id',$UserId)->update($updateData);

      return ['status'=>true,'message'=>__('Successfully updated')];

      if($User)
        return ['status'=>true,'message'=>__('Successfully updated')];
      else
        return ['status'=>false,'message'=>__('Failed to update')];
    }
  
      /**
    * End Point  :- user/forgot/password
    * Method     :- Post
    * Parameters :- rut_number
    *
    */
    public function forgotPassword(Request $request){
       
      $input    = $request->all();

      $rules = [
                'email' => 'required'
               ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        $errors =  $validator->errors()->all();
        return response(['status' => false , 'message' => $errors[0]] , 200);              
      }

      $User = User::where('email',$input['email'])->where('role_id','3')->whereNull('deleted_at')->first();

      if(empty($User) || is_null($User)){
          return ['status'=>false,'message'=>'This email address does not exist'];
      }

       if($User->is_active != '1'){
        return response(['status'=>false , 'message'=>__('Your are inactive , Please contact with your administrator')],401);
       }

      $token = app(PasswordBroker::class)->createToken($User);
      $data = array(
        'to'     => $User->email,
        'link'   => url('password/reset/'.$token)
      );

      try {
          \Mail::send('Mails.forgot_password', $data, function ($message) use($data) {
            $message->from( env('MAIL_FROM') , env('MAIL_FROM_NAME') );
            $message->to($data['to'])->subject('Reset password for Halch account');
          });
          return ['status'=>true,'message'=>'Reset password link sent to you email address'];
      } catch (\Exception $th) {
          return ['status' => false , 'message'=>'Failed to send reset password link'];
      }
      
    }

    /**
     *  Is User Exist
    */
    public function isUserExist($userId){
      $User = DB::table('users')->where('id',$userId)->where('role_id','3')->whereNull('deleted_at')->count();
      if($User)
        return true;
      else
        return false;
    }

}
