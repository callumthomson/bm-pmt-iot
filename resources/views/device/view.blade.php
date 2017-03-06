@extends('master')

@section('body')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/devices">Devices</a></li>
            <li class="active">{{ $device->name }}</li>
        </ol>
        <div class="col-sm-8 col-sm-offset-2">
            <h1>{{ $device->name }} <small>{{ $device->device_type->name }}</small></h1>
            <p>
                Created {{ $device->created_at->diffForHumans() }}, last updated <strong>{{ $device->updated_at->diffForHumans() }}</strong>
            </p>
            <hr>
            <h2>Status</h2>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Unit</th>
                </tr>
                @foreach($device->device_type->expected_data as $expected_data)
                <tr>
                    <td>{{ $expected_data['display'] }}</td>
                    @if($device->last_message)
                        <td>{{ $device->last_message->body[$expected_data['id']] }}</td>
                    @else
                        <td><em>No Data</em></td>
                    @endif
                    <td>{{ $expected_data['unit'] }}</td>
                </tr>
                @endforeach
            </table>
            <hr>
            <h2>Graphs</h2>
        </div>
    </div>
@endsection