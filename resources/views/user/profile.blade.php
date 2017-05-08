@extends('master')

@section('breadcrumb')
    <p class="navbar-text"><a href="{{url('/')}}">Home</a></p>
    <p class="navbar-text divider-vertical"></p>
    <p class="navbar-text">Profile</p>
@endsection

@section('body')
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">My Details</div>
                <div class="panel-body">
                    @if(Session::has('save_status'))
                        <div class="alert alert-success" role="alert">
                            Your details were saved.
                        </div>
                    @endif
                    @if(count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST">
                        <div class="form-group">
                            <label for="txt-name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txt-name" placeholder="Name" name="txt-name" value="{{ Auth::user()->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt-email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="txt-email" placeholder="Email" name="txt-email" value="{{ Auth::user()->email }}">
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
        </div>
    </div>
@endsection