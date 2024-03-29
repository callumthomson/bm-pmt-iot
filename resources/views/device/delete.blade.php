@extends('master')

@section('breadcrumb')
<p class="navbar-text"><a href="{{url('/')}}">Home</a></p>
<p class="navbar-text divider-vertical"></p>
<p class="navbar-text"><a href="{{url('/devices')}}">Devices</a></p>
<p class="navbar-text divider-vertical"></p>
<p class="navbar-text"><a href="{{url('/device/'.$device->id)}}">{{ $device->name }}</a></p>
<p class="navbar-text divider-vertical"></p>
<p class="navbar-text">Delete</p>
@endsection

@section('body')
    <div class="container">
        <div class="col-sm-8 col-sm-offset-2">
            <h1>Delete {{ $device->name }}</h1>
            <div class="alert alert-danger" role="alert">
                <i class="mdi mdi-alert"></i> This action is permanent and will also erase all communication history with the device!
            </div>
            <a class="btn btn-default" href="{{ url()->previous() }}">Cancel</a>
            <form method="POST" style="display: inline;">
                {!! csrf_field() !!}
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        </div>
    </div>
@endsection