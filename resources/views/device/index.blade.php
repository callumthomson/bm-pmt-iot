@extends('master')

@section('body')
    <div class="container">
        <h1>Devices</h1>
        <p>
            All of your devices are shown here with their type and the time since they were last heard from.
        </p>
        <a class="btn btn-primary" href="/device/create"><i class="glyphicon glyphicon-plus"></i> New</a>
        <br><br>
        <table class="table">
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
        </table>
    </div>
@endsection