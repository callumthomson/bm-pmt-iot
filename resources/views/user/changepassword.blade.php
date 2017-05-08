@extends('master')

@section('breadcrumb')
    <p class="navbar-text"><a href="{{url('/')}}">Home</a></p>
    <p class="navbar-text divider-vertical"></p>
    <p class="navbar-text">Change Password</p>
@endsection

@section('body')
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Change Password</div>
                <div class="panel-body">
                    @if(Session::has('password_error'))
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <li>You provided the wrong current password.</li>
                            </ul>
                        </div>
                    @endif
                        @if(Session::has('save_status'))
                        <div class="alert alert-success" role="alert">
                            Your password was changed.
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
                            <label for="txt-cpassword" class="col-sm-4 control-label">Current Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="txt-cpassword" placeholder="Current Password" name="txt-cpassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt-password1" class="col-sm-4 control-label">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="txt-password1" placeholder="New Password" name="txt-password1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt-password2" class="col-sm-4 control-label">Confirm New Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="txt-password2" placeholder="Confirm New Password" name="txt-password2">
                            </div>
                        </div>
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection