@extends('master')

@section('body')
    <div class="container">
        <h1>Devices</h1>
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Last Communication Received</th>
            </tr>
            @foreach($devices as $device)
                <tr>
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->device_type->name }}</td>
                    @if($device->last_message)
                    <td>{{ $device->last_message->created_at->diffForHumans() }}</td>
                    @else
                    <td>Never</td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection