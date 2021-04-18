@extends('layouts.loggedIn')

@section('title') {{__('Booking List')}} @endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">{{__('Bookings')}} ({{$bookings->total()}})</h3>
    </div>
</div>

@include('components.alert')

<div class="row">
    <div class="col-lg-12 text-right">

    </div>
</div>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th nowrap>{{__('Sr.')}}</th>
                        <th nowrap>{{__('Vendor')}}</th>
                        <th nowrap>{{__('User')}}</th>
                        <th nowrap>{{__('Service')}}</th>
                        <th nowrap>{{__('Service Cost')}}</th>
                        <th nowrap>{{__('Booking date')}}</th>
                        <th nowrap>{{__('Booking Time')}}</th>
                        <th nowrap>{{__('Booking Status')}}</th>
                        <th nowrap>{{__('Payment Status')}}</th>
                        <th nowrap>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = $bookings->perPage() * ($bookings->currentPage() - 1); @endphp
                    @foreach ($bookings as $key => $value)
                        <tr class="odd gradeX">
                            <td nowrap>{{++$i}}</td>
                            <td nowrap>{{$value->vendor->name}}</td>
                            <td nowrap>{{$value->user->name}}</td>
                            <td nowrap>{{$value->category_name}}>{{$value->service_name}}</td>
                            <td nowrap>{{$value->service_cost}}</td>
                            <td nowrap>{{date('Y M d',strtotime($value->booking_date))}}</td>
                            <td nowrap>{{date('H:i A',strtotime($value->booking_date))}}</td>
                            <td nowrap>
                                @switch($value->booking_status)
                                @case('1')
                                  {{__('Accept')}}
                                @break
                                @default
                                  {{__('Pending')}}
                                @endswitch
                            </td>
                            <td nowrap>
                                {{ $value->payment_status == 1 ? __('Paid') : __('Due') }}
                            </td>
                            <td nowrap>
                                <a href="{{route('show.booking',$value->id)}}" class="btn btn-sm btn-primary">Info</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12 text-right">
        {{ $bookings->links() }}
    </div>
</div>

@endsection
@push('css')
  <link rel="stylesheet" href="{{asset('public')}}/css/viewer.css">
  <link rel="stylesheet" href="{{asset('public')}}/css/viewer_main.css">
  <style>
      img {
            display: block;
            max-width:230px;
            max-height:95px;
            width: auto;
            height: auto;
        }
  </style>
@endpush
@push('js')
  <script type="text/javascript" src="{{asset('public')}}/js/viewer.js"></script>
  <script type="text/javascript" src="{{asset('public')}}/js/viewer_main.js"></script>
  <script>
    $('.btn-dlt').on('click',function(e){
       $('#deleteModal').modal('show');
       $('#deleteModal input[name="id"]').val($(this).attr('data-id'));
    });
</script>
@endpush
