@extends('layouts.app')

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form  method="POST" action="{{route('add.vehicle')}}" autocomplete="off" id="vehicle_form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Type</label>
                    <input type="text" required class="form-control" placeholder="Enter type"  name='type'>
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" required class="form-control" placeholder="Enter brand"  name='brand'>
                </div>
                <div class="form-group">
                    <label>Maximum passenger count</label>
                    <input type="number" required class="form-control" placeholder="Enter maximum passenger number"  name='max_passenger_number'>
                </div>
                <button type="submit" class="btn btn-success" >Add</button>
            </form>
        </div>
    </div>
</div>
@endsection

