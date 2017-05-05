@extends('master')

@section('breadcrumb')
    <p class="navbar-text"><a href="{{url('/')}}">Home</a></p>
    <p class="navbar-text divider-vertical"></p>
    <p class="navbar-text"><a href="{{url('/devices')}}">Devices</a></p>
    <p class="navbar-text divider-vertical"></p>
    <p class="navbar-text">{{ $device->name }}</p>
@endsection

@section('body')
    <div class="container">
        <div class="col-sm-8 col-sm-offset-2">
            <h1>{{ $device->name }}
                <small>{{ $device->device_type->name }}</small>
            </h1>
            <p>
                Created <span class="fromNow" time="{{ $device->created_at }}"></span>, last updated <strong
                        id="device_last_updated" class="fromNow" time="{{ $device->updated_at }}"></strong>
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
                        <td>{!! $expected_data['unit'] !!}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
            <h2>Graphs</h2>
            <div id="chart_div"></div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {packages: ['corechart', 'line']});
        var chart_columns = [];

        (function () {


            google.charts.setOnLoadCallback(getDeviceMessages);

            setInterval(function () {
                getDeviceMessages({{ $device->id }});
            }, 5000);

            function getDeviceMessages() {
                var device_id = {{$device->id}};
                $.ajax({
                    url: "{{url('/data/device/'.$device->id.'/test')}}",
                    success: function (data) {
                        var new_data = [];
                        $('#device_last_updated');
                        $.each(data.data, function (i, v) {
                            new_data[i] = [];
                            new_data[i][0] = new Date(v.created_at);
                            var num = 1;
                            $.each(v.body, function (ii, vv) {
                                new_data[i][num] = vv;
                                num++;
                            })
                        })
                        drawBasic(new_data);
                        return new_data;
                    }
                })
            };
            getDeviceTypeInformation();
            function getDeviceTypeInformation() {
                var device_id = {{$device->id}};
                $.ajax({
                    url: "{{url('/data/device/'.$device->id.'/expected')}}",
                    success: function (data) {
                        var new_columns = [];
                        new_columns[0] = ['datetime', 'Date'];
                        $.each(data.expected_data, function (i, v) {
                            new_columns[i + 1] = ['number', v.display];
                        })
                        console.log(new_columns);
                        chart_columns = new_columns;
                    }
                })
            };

            function drawBasic(include_data = []) {
                var data = new google.visualization.DataTable();
                var options = {
                    backgroundColor: '#F2F2F2',
                    legend: { position: 'top', alignment: 'start' },
                    title: null,
                    hAxis: {
                        title: 'Time'
                    },
                    vAxis: {
                        title: '{{html_entity_decode($device->device_type->expected_data[0]['unit'])}}'
                    }
                };
                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));


                $.each(chart_columns, function (i, v) {
                    data.addColumn(v[0], v[1]);
                })

                console.log(include_data);

                data.addRows(
                        include_data
                );

                chart.draw(data, options);
            }
        })()
    </script>

@endsection