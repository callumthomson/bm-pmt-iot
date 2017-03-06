@extends('master')

@section('body')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/devices">Devices</a></li>
            <li class="active">{{ $device->name }}</li>
        </ol>
        <div class="col-sm-8 col-sm-offset-2">
            <h1>{{ $device->name }} <small>{{ $device->device_type->name }}</small></h1>
            <p>
                Created {{ $device->created_at->diffForHumans() }}, last updated <strong>{{ $device->updated_at->diffForHumans() }}</strong>
            </p>
            <hr>
            <h2>Status</h2>
            <hr>
            <h2>Graphs</h2>
        </div>
    </div>
@endsection