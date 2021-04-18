@extends('layouts.loggedIn')

@section('title') {{__('Update Service')}} - {{$service->categoryService->service->title}} @endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">{{__('Update Service')}} <button class="btn btn-danger btn-sm btn-dlt">Delete</button></h3>
    </div>
</div>
<br/>
        <div class="row">
            <div class="col-md-6 col-offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <form class="form" action="{{route('update.myservice',$service->id)}}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <select class="form-control" name="category">
                                      <option value="">{{__('Select Category')}}</option>
                                    @foreach(App\Models\Category::orderBy('title','asc')->get() as $key => $value)  
                                      <option @if($service->categoryService->category_id == $value->id ) selected @endif value="{{$value->id}}">{{$value->title}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="service">
                                      <option value="">{{__('Select Service')}}</option>
                                </select>
                                @error('service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="service_cost" value="{{$service->service_cost}}" placeholder="{{__('Serivce Cost')}}" required/>
                                @error('service_cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_active" value="1" @if($service->is_active) checked @endif/> Active
                                </label>
                            </div>
                            <input type="submit" value="{{__('Update')}}" class="btn btn-primary float-right"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal -->
 <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog modal-md">
        <form class="form" action="{{route('delete.myservice')}}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{__('Delete Service')}}</h4>
        </div>
        <div class="modal-body">
                @csrf
                {{ method_field('DELETE') }}
                 <input type="hidden" name="id" value="{{$service->id}}">
                 <p>{{__('Are you sure want to delete service?')}}</p>
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

@include('components.backBtn')
@endsection
@push('js')
 <script>
        //Image Preview
        $('input[name="service_image"]').on('change',function(e){
            tmppath = URL.createObjectURL(event.target.files[0]);
            $('.image-preview').attr('src',tmppath);
        });
        $('.btn-dlt').on('click',function(e){
            e.preventDefault();
            $('#deleteModal').modal('show');
        });
        
        var categoryId = null;
        @if(old('category'))
            categoryId = "{{old('category')}}";
        @endif
        @if($service->categoryService->category_id)
            categoryId = "{{$service->categoryService->category_id}}";
        @endif

        var serviceId = "{{$service->service_id}}";

        var getService = function(categoryId){
            $.ajax({
               'type' : 'GET',
               'url'  : "{{url('/ajax/get/services?category_id=')}}" + categoryId + '&service_id=' + serviceId,
               'success' : function(response){
                   var html = '';
                   if(response.status){
                       response.data.map(function(service,index){
                           selected = '';
                           if(serviceId == service.service_id)
                                 selected = 'selected';
                           if(index == 0){
                              html += `<option value="">{{__('Select Service')}}</option>`;
                           }
                           html += `<option ${selected} value="${service.service_id}">${service.service}</option>`;
                       });
                   }else{
                       html += `<option value="">{{__('Service not availabe')}}</option>`;
                   }
                      $('select[name="service"]').html(html);
               },
               'error' : function(error){
                   console.log(error);
               }
            });
        }

        if(categoryId){
            getService(categoryId);
        }

        $('select[name="category"]').on('change',function(e){
              e.preventDefault();
              getService(e.target.value);
        });

 </script>
@endpush