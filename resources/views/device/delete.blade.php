@extends('master')

@section('body')
    <div class="container">
        <div class="col-sm-8 col-sm-offset-2">
            <h1>Delete {{ $device->name }}</h1>
            <div class="alert alert-danger" role="alert">
                <i class="glyphicon glyphicon-exclamation-sign"></i> This action is permanent and will also erase all communication history with the device!
            </div>
            <a class="btn btn-default" href="/devices">Cancel</a>
            <form method="POST" style="display: inline;">
                {!! csrf_field() !!}
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        </div>
    </div>
@endsection