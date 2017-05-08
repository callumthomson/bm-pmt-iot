@extends('master')

@section('breadcrumb')
    <p class="navbar-text"><a href="{{url('/')}}">Home</a></p>
    <p class="navbar-text divider-vertical"></p>
    <p class="navbar-text">Login</p>
@endsection

@section('body')
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    @if(Session::has('login_error'))
                        <div class="alert alert-danger" role="alert">
                            Invalid credentials entered.
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST">
                        <div class="form-group">
                            <label for="txt-email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="txt-email" placeholder="Email" name="txt-email" value="{{ old('txt-email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt-password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="txt-password" placeholder="Password" name="txt-password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="chk-remember" value="0">
                                        <input type="checkbox" name="chk-remember" value="1"> Remember me
                                    </label>
                                </div>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection