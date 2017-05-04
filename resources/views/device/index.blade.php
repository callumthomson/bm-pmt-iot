@extends('master')

@section('breadcrumb')
<p class="navbar-text"><a href="/">Home</a></p>
<p class="navbar-text divider-vertical"></p>
<p class="navbar-text">Devices</p>
@endsection

@section('body')
    <div class="container">
<!--         <h1>Devices</h1> -->
        <p>
            All of your devices are shown here with their type and the time since they were last heard from.
        </p>
<!--         <a class="btn btn-primary" href="/device/create"><i class="glyphicon glyphicon-plus"></i> New</a> -->
		@if(isset($devices))
			<div class="list-group">
				@foreach($devices as $device)
					<a class="list-group-item clearfix flex-parent contains-controls" href="device/{{$device->id}}">
						<div class="col-md-3 col-sm-12">{{ $device->name }}</div>
						<div class="col-md-2 col-sm-2">{{ $device->device_type->name }}</div>
						@if($device->last_message)
						<div class="flex-child col-sm-2 fromNow" time="{{$device->last_message->created_at}}"></div>
						@else
						<div class="flex-child col-sm-2">Never</div>
						@endif
						<div class="btn btn-clear pull-right open-href" href="device/{{$device->id}}/edit"><i class="glyphicon glyphicon-pencil"></i></div>
						<div class="btn btn-clear pull-right open-href" href="device/{{$device->id}}/delete"><i class="glyphicon glyphicon-trash"></i></div>
					</a>
				@endforeach
			</div>
		@else
			<p>You have no devices</p>
		@endif
				
    </div>
@endsection

@section('fab')
<!-- 	<div class="fab-secondary">
		<a href=""><i class="glyphicon glyphicon-pencil"></i></a>
	</div> -->
	<div class="fab-main" onclick="location.href='/device/create'"><i class="glyphicon glyphicon-plus"></i></div>
@endsection

@section('scripts')
<script>
	$(document).on('click', '.open-href', function(e){
		e.preventDefault();
		e.stopPropagation();
		console.log('open-href', this, $(this).attr('href'));
		location.href=$(this).attr('href');
	})
</script>
@endsection