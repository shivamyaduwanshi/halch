@extends('layouts.loggedIn')

@section('title') {{__('Vendor')}} | {{$data['vendor']->name}} @endsection

@section('content')
<section class="gr-user-details">
    <div class="shadow-wrapper">
        <div class="custom-img-txt clearfix">
            <div class="img">
                <img src="{{$data['vendor']->profile_image}}" alt="{{$data['vendor']->name}}">
            </div>
            <div class="txt">
               <p> <i class="fa fa-universal-access"></i> {{$data['vendor']->rut_number ?? '-'}}</p>
                <p> <i class="fa fa-user"></i> {{$data['vendor']->name}}</p>
                <p> <i class="fa fa-envelope"></i> {{$data['vendor']->email}}</p>
                <p> <i class="fa fa-phone"></i>{{$data['vendor']->phone}}</p>
                <p> <i class="fa fa-circle" @if($data['vendor']->is_active == '1') style="color:green" @else style="color:red"  @endif></i>{{$data['vendor']->is_active == '1' ? 'Active' : 'Deactive'}}</p>
            </div>
        </div>
        <div class="c-border"></div>
        <div class="custom-description">
            <h2>{{__('Other Details')}}</h2>
            <p><span>{{__('Address')}}:</span> {{$data['vendor']->address}}</p>
            <p><span>{{__('Total Bookings')}}:</span> {{$data['vendor']->totalBookings($data['vendor']->id)}}&nbsp;<a href="{{route('products',['vendor'=>$data['vendor']->id])}}">({{__('See Bookings')}})</a></p>
        </div>
        <br/>
        <div class="btn-wrapper">
            <button class="btn btn-dlt btn-danger">{{__('Delete')}}</button>
            @if($data['vendor']->is_active == '1')
            <button class="btn btn-deactive btn-primary">{{__('Deactive')}}</button>
            @else
            <button class="btn btn-active btn-primary">{{__('Active')}}</button>
            @endif
        </div>
    </div>
</section>

 <!-- Modal -->
 <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog modal-md">
        <form class="form" action="{{route('delete.vendor')}}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{__('Delete Vendor')}}</h4>
        </div>
        <div class="modal-body">
                @csrf
                {{ method_field('DELETE') }}
                 <input type="hidden" name="id" value="{{$data['vendor']->id}}">
                 <div class="form-group">
                      <textarea class="form-control" name="reason" placeholder="{{__('Why are you delete this vendor account?(Optional)')}}"></textarea>
                 </div>
                 <label><input type="checkbox" name="is_notify" checked value="1"/>&nbsp;&nbsp;&nbsp;{{__('Notify to vendor')}}</label>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
          <input type="submit" class="btn btn-danger" value="{{__('Delete')}}" />
        </div>
      </div>
    </form>
    </div>
  </div>
</div>

 <!-- Modal -->
 <div class="modal fade" id="deactiveModal" role="dialog">
    <div class="modal-dialog modal-md">
        <form class="form" action="{{route('deactive.vendor')}}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{__('Deactive vendor')}}</h4>
        </div>
        <div class="modal-body">
                @csrf
                {{ method_field('PUT') }}
                 <input type="hidden" name="id" value="{{$data['vendor']->id}}">
                 <div class="form-group">
                      <textarea class="form-control" name="reason" placeholder="{{__('Why are you deactive this vendor account?(Optional)')}}"></textarea>
                 </div>
                 <label><input type="checkbox" name="is_notify" checked value="1"/>&nbsp;&nbsp;&nbsp;{{__('Notify to vendor')}}</label>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
          <input type="submit" class="btn btn-primary" value="{{__('Deactive')}}" />
        </div>
      </div>
    </form>
    </div>
  </div>

   <!-- Modal -->
 <div class="modal fade" id="activeModal" role="dialog">
    <div class="modal-dialog modal-md">
        <form class="form" action="{{route('active.vendor')}}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{__('Active Vendor')}}</h4>
        </div>
        <div class="modal-body">
                @csrf
                {{ method_field('PUT') }}
                 <input type="hidden" name="id" value="{{$data['vendor']->id}}">
                 <label><input type="checkbox" name="is_notify" checked value="1"/>&nbsp;&nbsp;&nbsp;{{__('Notify to vendor')}}</label>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
          <input type="submit" class="btn btn-primary" value="{{__('Active')}}" />
        </div>
      </div>
    </form>
    </div>
  </div>

@include('components.backBtn')
@endsection
@push('js')
   <script>
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
