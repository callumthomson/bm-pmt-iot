<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
    </div>
    <div class="breadcrumb-holder">
<!--       <div> -->
        @yield('breadcrumb')
<!--       </div> -->
    </div>
    @if(Auth::check())
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li class="disabled"><a href="#">{{ Auth::user()->email }}</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="/logout">Logout</a></li>
          </ul>
      </li>
    </ul>
    @endif
  </div>
</nav>