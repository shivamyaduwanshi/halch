@extends('layouts.loggedIn')

@section('title') Membership Plan List @endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Membership Plans ({{$data['memberships']->total()}})</h1>
    </div>
</div>

@include('components.alert')

<br/>
<div class="row">
    <div class="col-lg-12 text-right">
        <a href="{{route('export.membership')}}" class="btn btn-primary">Export Plans</a>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Recruit RM Bonus Amount</th>
                        <th>First Generation</th>
                        <th>Second Generation</th>
                        <th>Third Generation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = $data['memberships']->perPage() * ($data['memberships']->currentPage() - 1); @endphp
                    @foreach ($data['memberships'] as $key => $value)
                        <tr class="odd gradeX">
                            <td>{{++$i}}</td>
                            <td>{{$value->title}} ({{$value->sub_title}})</td>
                            <td>RM {{$value->price}}</td>
                            <td>RM {{$value->recruit_rm_bonus_amount}}</td>
                            <td> {{$value->first_generation }} %</td>
                            <td> {{$value->second_generation }} %</td>
                            <td> {{$value->third_generation }} %</td>
                            <td>
                                <a href="{{route('edit.membership',$value->id)}}" class="btn btn-sm btn-primary">Info</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12 text-right">
        {{ $data['memberships']->links() }}
    </div>
</div>
@endsection
