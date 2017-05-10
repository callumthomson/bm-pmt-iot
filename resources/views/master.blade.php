<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8"> @yield('head-start')
	<title>{{ $title or 'Default' }}</title>
	<link rel="stylesheet" href="{{ asset(mix('/css/app.css')) }}">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="//cdn.materialdesignicons.com/1.9.32/css/materialdesignicons.min.css">
	@yield('head-end')
</head>

<body>
	@include('layout.nav.nav') 
	@yield('body')
	<div class="fab-parent">
		@yield('fab')
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="{{asset('js/moment.min.js')}}"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
	$(document).ready(function(){
		$.each($('.fromNow'), function(i,v){
			$(v).text(moment($(v).attr('time')).fromNow());
		})
	})
	</script>
	@yield('scripts')
</body>

</html>