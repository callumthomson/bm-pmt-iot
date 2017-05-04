@extends('master')

@section('breadcrumb')
<p class="navbar-text"><a href="{{url('/')}}">Home</a></p>
<p class="navbar-text divider-vertical"></p>
<p class="navbar-text"><a href="{{url('/devices')}}">Devices</a></p>
<p class="navbar-text divider-vertical"></p>
<p class="navbar-text"><a href="{{url('/device/'.$device->id)}}">{{ $device->name }}</a></p>
<p class="navbar-text divider-vertical"></p>
<p class="navbar-text">Edit</p>
@endsection

@section('body')
    <div class="container">
        <div class="col-sm-8 col-sm-offset-2">
            <h1>Update {{ $device->name }}</h1>
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" placeholder="Name" name="txt-name" value="{{ $device->name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputType" class="col-sm-2 control-label">Type</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="inputType" name="sel-type">
                            @foreach(App\DeviceType::all() as $deviceType)
                                <option value="{{ $deviceType->id }}" @if($deviceType == $device->device_type) selected="selected" @endif>{{ $deviceType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {!! csrf_field() !!}
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection