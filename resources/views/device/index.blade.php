@extends('master')

@section('body')
    <div class="container">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Type</th>
            </tr>
            @foreach($devices as $device)
                <tr>
                    <td>{{$device->name }}</td>
                    <td>{{ $device->device_type->name }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection