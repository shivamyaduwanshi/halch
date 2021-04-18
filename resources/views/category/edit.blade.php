@extends('layouts.loggedIn')

@section('title') {{__('Update Category')}} - {{$category->title}} @endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{__('Update Category')}} <button class="btn btn-danger btn-dlt">{{__('Delete')}}</button></h1>
    </div>
</div>
<br/>
        <div class="row">
            <div class="col-md-6 col-offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <form class="form" action="{{route('update.category',$category->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" value="{{$category->title}}" placeholder="{{__('Title')}}" required/>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <select name="service[]" class="form-control" multiple>
                                    <option value="">{{__('Select Services')}}</option>
                                    @foreach($services as $key => $service)
                                       <option @if(in_array($service->id,$selectedServices)) selected @endif value="{{$service->id}}">{{$service->title}}</option>
                                    @endforeach
                                </select>
                                @error('service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="img-preview">
                               <img class="image-preview" src="{{$category->image}}" width="100%" height="200px"/>
                            </div>
                            <br/>
                            <div class="form-group">
                                <input type="file" class="form-control" name="category_image" accept="image/*" placeholder="{{__('Category Image')}}"/>
                                @error('category_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_active" value="1" @if($category->is_active) checked @endif/> {{__('Active')}}
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
        <form class="form" action="{{route('delete.category')}}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{__('Delete Category')}}</h4>
        </div>
        <div class="modal-body">
                @csrf
                {{ method_field('DELETE') }}
                 <input type="hidden" name="id" value="{{$category->id}}">
                 <p>{{__('Are you sure want to delete category?')}}</p>
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
        $('input[name="category_image"]').on('change',function(e){
            tmppath = URL.createObjectURL(event.target.files[0]);
            $('.image-preview').attr('src',tmppath);
        });
        $('.btn-dlt').on('click',function(e){
            e.preventDefault();
            $('#deleteModal').modal('show');
        });
 </script>
@endpush