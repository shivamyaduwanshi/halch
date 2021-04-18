@extends('layouts.loggedIn')

@section('title') {{__('Update Membership Plan')}} | {{$data['membership']->title}} @endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">{{__('Update Membership Plan')}} <small>{{$data['membership']->title}} ({{$data['membership']->sub_title}})</small></h3>
    </div>
</div>
<br/>
        <div class="row">
            <div class="col-md-6 col-offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <form class="form" action="{{route('update.membership',$data['membership']->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>{{__('Title')}}</label>
                                <input type="text" class="form-control" name="title" placeholder="{{__('Title')}}" value="{{old('title') ?? $data['membership']->title }}" required/>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{__('Sub Title')}}</label>
                                <input type="text" class="form-control" name="sub_title" placeholder="{{__('Sub Tilte')}}" value="{{old('sub_title') ?? $data['membership']->sub_title }}" required/>
                                @error('sub_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{__('Price')}} (RM)</label>
                                <input type="number" class="form-control" name="price" placeholder="{{__('Price')}}" value="{{old('price') ?? $data['membership']->price }}" required/>
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{__('Recruit Bonus Amount')}} (RM)</label>
                                <input type="number" class="form-control" name="recruit_rm_bonus_amount" placeholder="{{__('Recruit RM Bonus Amount')}}" value="{{old('recruit_rm_bonus_amount') ?? $data['membership']->recruit_rm_bonus_amount }}" required/>
                                @error('recruit_rm_bonus_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>First Generation %</label>
                                <input type="number" class="form-control" name="first_generation" placeholder="First Generation" value="{{old('first_generation') ?? $data['membership']->first_generation }}" required/>
                                @error('first_generation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Second Generation %</label>
                                <input type="number" class="form-control" name="second_generation" placeholder="Second Generation" value="{{old('second_generation') ?? $data['membership']->second_generation }}" required/>
                                @error('second_generation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Third Generation %</label>
                                <input type="number" class="form-control" name="third_generation" placeholder="Third Generation" value="{{old('third_generation') ?? $data['membership']->third_generation }}" required/>
                                @error('third_generation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_active" value="1" @if($data['membership']->is_active == '1') checked @endif /> Active
                                </label>
                            </div>
                            <input type="submit" value="Update" class="btn btn-primary float-right"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@include('components.backBtn')
@endsection
@push('js')
 <script>
        //Image Preview
        $('input[name="banner_image"]').on('change',function(e){
            tmppath = URL.createObjectURL(event.target.files[0]);
            $('.image-preview').attr('src',tmppath);
        });
 </script>
@endpush