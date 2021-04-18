@extends('layouts.loggedIn')

@section('title') {{__('Booking Details')}} | #{{$booking->id}} @endsection

@section('content')
<section class="gr-user-details">
<div class="shadow-wrapper">
        <div class="custom-description">
            <h2>{{__('Booking Details')}}</h2>
            <p><span>{{__('Booking ID')}}   </span> #{{$booking->id}}</p>
            <p><span>{{__('Booking Date')}} </span> {{date('Y M d',strtotime($booking->booking_date))}}  at {{date('H:i A',strtotime($booking->booking_time))}} </p>
            <p><span>{{__('Booking Start Date')}} </span> {{date('Y M d',strtotime($booking->start_date))}} at {{date('H:i A',strtotime($booking->start_time))}}</p>
            <p><span>{{__('Booking End Date')}} </span> {{date('Y M d',strtotime($booking->end_date))}}  at {{date('H:i A',strtotime($booking->end_time))}} </p>
            <p><span>{{__('Service')}}      </span> {{$booking->category_name}} > {{$booking->service_name}}</p>
            <p><span>{{__('Service Cost')}} </span> {{$booking->service_cost}}</p>
            <p><span>{{__('Booking Status')}} </span>  
                                @switch($booking->booking_status)
                                @case('1')
                                  {{__('Accept')}}
                                @break
                                @default
                                  {{__('Pending')}}
                                @endswitch </p>
            <p><span>{{__('Payment Status')}} :</span> {{$booking->payment_status ? __('Paid') : __('Due')}}</p>
        </div>
    </div>
    <br>
    <div class="shadow-wrapper">
        <div class="custom-description">
            <h2>{{__('User Details')}}</h2>
            <p><span>{{__('ID')}}      </span> #{{$booking->user_id}}</p>
            <p><span>{{__('RUT')}}     </span> {{$booking->user->rut_number ?? '-'}}</p>
            <p><span>{{__('Name')}}    </span> {{$booking->user->name  ?? '-'}}</p>
            <p><span>{{__('Phone')}}   </span> {{$booking->user->phone ?? '-'}}</p>
            <p><span>{{__('Email')}}   </span> {{$booking->user->email ?? '-'}}</p>
        </div>
    </div>
    <br>
</section>
@include('components.backBtn')
@endsection
@push('js')
@endpush
