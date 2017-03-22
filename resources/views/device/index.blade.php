@extends('master')

@section('body')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Devices</li>
        </ol>
        <h1>Devices</h1>
        <p>
            All of your devices are shown here with their type and the time since they were last heard from.
        </p>
        <a class="btn btn-primary" href="/device/create"><i class="glyphicon glyphicon-plus"></i> New</a>
        <br><br>
<!--         <table class="table">
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Last Communication Received</th>
                <th>Actions</th>
            </tr>
            @foreach($devices as $device)
                <tr onclick="location.href='/device/{{ $device->id }}'" style="cursor:pointer;">
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->device_type->name }}</td>
                    @if($device->last_message)
                    <td>{{ $device->last_message->created_at->diffForHumans() }}</td>
                    @else
                    <td>Never</td>
                    @endif
                    <td>
                        <a class="btn btn-default" href="/device/{{ $device->id }}/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a class="btn btn-danger" href="/device/{{ $device->id }}/delete"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                    </td>
                </tr>
            @endforeach
        </table> -->
		@if(isset($devices))
        	<div class="list-group">
				@foreach($devices as $device)
					<div class="list-group-item clearfix flex-parent span-controls-parent" onclick="location.href='/device/{{ $device->id }}'">
						<span class="col-md-3">{{ $device->name }}</span>
						<span class="col-md-2">{{ $device->device_type->name }}</span>
						@if($device->last_message)
						<span class="flex-child">{{ $device->last_message->created_at->diffForHumans() }}</span>
						@else
						<span class="flex-child">Never</span>
						@endif
						<span class="col-md-2 span-controls">
							<a href="device/{{ $device->id }}/edit" class="btn btn-clear pull-right"><i class="glyphicon glyphicon-pencil"></i></a>
							<a href="device/{{ $device->id }}/delete" class="btn btn-clear pull-right"><i class="glyphicon glyphicon-trash"></i></a>
						</span>
					</div>
				@endforeach
        	</div>
		@else
			<p>You have no devices</p>
		@endif
				
    </div>
@endsection