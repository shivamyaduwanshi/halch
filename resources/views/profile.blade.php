@extends('layouts.loggedIn')

@section('title') {{__('Profile')}} | {{ auth::user()->name}} @endsection

@section('content')

<section class="gr-user-details">
    @include('components.alert')
    <div class="shadow-wrapper">
        <div class="custom-img-txt clearfix">
            <div class="row">
                 <div class="col-md-6 ">
                     <h4>{{__('Profile Details')}}</h4>
                     <form class="form" action="{{route('update.profile')}}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                          <div class="form-group">
                              <label>{{__('Name')}}</label>
                              <input type="name" value="{{old('name') ?? auth::user()->name}}" name="name" placeholder="{{__('Name')}}" class="form-control"/>
                              @if ($errors->has('name'))
                              <span class="invalid-feedback text-error" role="alert">
                                 <strong>{{ $errors->first('name') }}</strong>
                              </span>
                               @endif
                            </div>
                          <div class="form-group">
                              <label>{{__('Email')}}</label>
                              <input type="email" value="{{old('email') ?? auth::user()->email}}" name="email" placeholder="{{__('Email')}}" class="form-control"/>
                                @if ($errors->has('email'))
                              <span class="invalid-feedback text-error" role="alert">
                                 <strong>{{ $errors->first('email') }}</strong>
                              </span>
                               @endif
                            </div>
                          <div class="form-group">
                              <label>{{__('Phone')}}</label>
                              <input type="phone" value="{{old('phone') ?? auth::user()->phone}}" name="phone" placeholder="{{__('Phone')}}" class="form-control"/>
                              @if ($errors->has('phone'))
                              <span class="invalid-feedback text-error" role="alert">
                                 <strong>{{ $errors->first('phone') }}</strong>
                              </span>
                              @endif
                            </div>
                          <input type="submit" class="btn btn-primary" value="{{__('Update')}}"/>
                     </form>
                 </div>
            </div>
        </div>
    </div>
</section>

<section class="gr-user-details" style="margin-top: -65px">
    <div class="shadow-wrapper">
        <div class="custom-img-txt clearfix">
            <div class="row">
                 <div class="col-md-6 ">
                     <h4>{{__('Your Services')}}</h4>
                     <form class="form" action="{{route('add.service')}}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                           <div class="form-group">
                              <label>{{__('Services')}}</label>
                              <select class="form-control" name="service[]" multiple>
                                 @foreach($services as $key => $service)
                                   @if($key == '0')
                                      <option value="">Select multiple service</option>
                                   @endif
                                   <option @if(in_array($service->id,$selectedService)) selected @endif value="{{$service->id}}">{{ $service->title }}</option>
                                 @endforeach
                              </select>
                              @if ($errors->has('service'))
                              <span class="invalid-feedback text-error" role="alert">
                                 <strong>{{ $errors->first('service') }}</strong>
                              </span>
                               @endif
                           </div>
                          <input type="submit" class="btn btn-primary" value="{{__('Update')}}"/>
                     </form>
                 </div>
            </div>
        </div>
    </div>
</section>

@php 
  $planDetails = auth::user()->currentPlan();
@endphp

<section class="gr-user-details" style="margin-top: -65px">
    <div class="shadow-wrapper">
        <div class="custom-img-txt clearfix">
            <div class="row">
                 <div class="col-md-6 ">
                      <h4>{{__('Plan Details')}}</h4>
                      @if($planDetails)
                        <p><span style="font-weight:bold">{{__('Title')}}</span> : {{$planDetails['title'] ?? ''}}</p>
                        <p><span style="font-weight:bold">{{__('Active Date')}}</span> : {{$planDetails['plan_active_date'] ?? ''}}</p>
                        <p><span style="font-weight:bold">{{__('Expiry Date')}}</span> : {{$planDetails['plan_expiry_date'] ?? ''}}</p>
                      @else
                        <p style="color:red">{{__('You have no any active plan')}}, <a style="color:black" href="{{route('index.membership')}}">{{__('Buy Plan')}}</a></p>
                      @endif
                 </div>
            </div>
        </div>
    </div>
</section>

<section class="gr-user-details" style="margin-top: -65px">
    <div class="shadow-wrapper">
        <div class="custom-img-txt clearfix">
            <div class="row">
                 <div class="col-md-6 ">
                     <h4>{{__('Change Password')}}</h4>
                     <form class="form" action="{{route('change.password')}}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                          <div class="form-group">
                              <label>{{__('Old Password')}}</label>
                              <input type="password" value="" name="old_password" placeholder="{{__('Old Password')}}" class="form-control"/>
                              @if ($errors->has('old_password'))
                              <span class="invalid-feedback text-error" role="alert">
                                 <strong>{{ $errors->first('old_password') }}</strong>
                              </span>
                               @endif
                            </div>
                          <div class="form-group">
                              <label>{{__('New Password')}}</label>
                              <input type="password" value="" name="new_password" placeholder="{{__('New Password')}}" class="form-control"/>
                                @if ($errors->has('new_password'))
                              <span class="invalid-feedback text-error" role="alert">
                                 <strong>{{ $errors->first('new_password') }}</strong>
                              </span>
                               @endif
                            </div>
                          <div class="form-group">
                              <label>Confirm Password</label>
                              <input type="password" value="" placeholder="{{__('Confirm password')}}" name="confirm_password" class="form-control"/>
                              @if ($errors->has('confirm_password'))
                              <span class="invalid-feedback text-error" role="alert">
                                 <strong>{{ $errors->first('confirm_password') }}</strong>
                              </span>
                              @endif
                            </div>
                          <input type="submit" class="btn btn-primary" value="{{__('Update')}}"/>
                     </form>
                 </div>
            </div>
        </div>
    </div>
</section>
@include('components.backBtn')
@endsection
@push('css')
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('js')
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script>
       $('select').select2();
       $('.btn-dlt').on('click',function(e){
          $('#deleteModal').modal('show');
       });
       $('.btn-deactive').on('click',function(e){
          $('#deactiveModal').modal('show');
       });
       $('.btn-active').on('click',function(e){
          $('#activeModal').modal('show');
       });
   </script>
@endpush
