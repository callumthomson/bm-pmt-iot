<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
    </div>
    <div class="breadcrumb-holder">
<!--       <div> -->
        @yield('breadcrumb')
<!--       </div> -->
    </div>
  </div>
</nav>