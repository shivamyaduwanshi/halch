@extends('layouts.loggedIn')

@section('title') Dashboard @endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">{{__('Hello')}}, {{ auth::user()->name }}</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
@include('components.alert')
@if(!auth::user()->isPlanActive() && auth::user()->role_id != '1')
<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close"></button>
        <strong><a style="text-decoration:none;color:#e05960" href="{{route('index.plan')}}">{{__('Buy Plan')}}!</a></strong> {{__('You have no any plan')}}
</div>
@endif
<!-- /.row -->
<div class="row">
@if(auth::user()->role_id == '1')
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ DB::table('users')->where('role_id','2')->whereNull('deleted_at')->count()}}</div>
                        <div>{{__('Vendors')}}</div>
                    </div>
                </div>
            </div>
            <a href="{{route('index.vendor')}}">
                <div class="panel-footer">
                    <span class="pull-left">{{__('View Details')}}</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ DB::table('users')->where('role_id','3')->whereNull('deleted_at')->count()}}</div>
                        <div>{{__('Users')}}</div>
                    </div>
                </div>
            </div>
            <a href="{{route('index.user')}}">
                <div class="panel-footer">
                    <span class="pull-left">{{__('View Details')}}</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    @endif
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-book fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                           @if(auth::user()->role_id == '1')
                            {{ DB::table('bookings')->whereNull('deleted_at')->count()}}
                           @else
                            {{ DB::table('bookings')->where('vendor_id',auth::user()->id)->whereNull('deleted_at')->count()}}
                           @endif
                        </div>
                        <div>{{__('Bookings')}}</div>
                    </div>
                </div>
            </div>
            <a href="{{route('index.booking')}}">
                <div class="panel-footer">
                    <span class="pull-left">{{__('View Details')}}</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-leaf fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">
                        @if(auth::user()->role_id == '1')
                          {{ DB::table('services')->whereNull('deleted_at')->count()}}
                        @else
                          {{ DB::table('vendor_services')->where('vendor_id',auth::user()->id)->whereNull('deleted_at')->count()}}
                        @endif
                        </div>
                        @if(auth::user()->role_id == '1')
                          <div>{{__('Services')}}</div>
                        @else
                          <div>{{__('My Services')}}</div>
                        @endif
                    </div>
                </div>
            </div>
            @if(auth::user()->role_id == '1')
              <a href="{{route('index.service')}}">
            @else
              <a href="{{route('index.myservice')}}">
            @endif
                <div class="panel-footer">
                    <span class="pull-left">{{__('View Details')}}</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    @if(auth::user()->role_id == '1')
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-stack-overflow fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ DB::table('categories')->whereNull('deleted_at')->count()}}</div>
                        <div>{{__('Categories')}}</div>
                    </div>
                </div>
            </div>
            <a href="{{route('index.category')}}">
                <div class="panel-footer">
                    <span class="pull-left">{{__('View Details')}}</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
