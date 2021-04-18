@extends('layouts.loggedIn')

@section('title') {{__('Plan')}} @endsection

@include('components.alert')

@php
   $plans = \DB::table('plans')->where('is_active','1')->whereNull('deleted_at')->get();
@endphp
@section('content')
<div style="page">
  <div class="plan-wrapper">
   @foreach($plans as $key => $value)
    <div class="plan">
      <h1>{{$value->title}}</h1>
      <h3>$ {{$value->price}}</h3>
      <a href="{{route('buy.plan',['plan_id'=>$value->id])}}" class="btn btn-primary">{{__('Buy')}}</a>
    </div>
    @endforeach
  </div>
</div>
<style>
.page{
  position:relative;
}
.plan-wrapper{
  position:absolute;
  top:30%;
  left:35%;
  tranform:translate(-30%,-35%);
}
   .plan{
      display:inline-block;
      text-align:center;
      border:1px solid #337ab7;
      border-radius:5px;
      padding:10px;
      width:300px;
   }
</style>
@endsection
