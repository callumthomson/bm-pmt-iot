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
            <div id="chart_div"></div>
        </div>
    </div>
@endsection

@section('scripts')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	google.charts.load('current', {packages: ['corechart', 'line']});
	var include_data = [
		[new Date('2017-03-15 13:15:43'), 0, -1],
		[new Date('2017-03-15 13:17:24'), 10, 8],
		[new Date('2017-03-15 13:24:41'), 23, 23]
	];
	(function(){
		google.charts.setOnLoadCallback(getDeviceMessages);

		setTimeout(function(){
	// 		getDeviceMessages({{$device->id}})
		}, 500)
		setInterval(function(){
			getDeviceMessages({{ $device->id }});
		}, 5000);

		function loadAjaxData(device_id){
			getDeviceMessages(device_id);
		}

		function getDeviceMessages(){
			var device_id = {{$device->id}};
			$.ajax({
				url: 'http://' + window.location.hostname + '/data/device/' + device_id,
	// 			async: false,
				success: function(data){
					var new_data = [];
					$.each(data.data, function(i,v){
						new_data[i] = [];
						new_data[i][0] = new Date(v.created_at);
						var num = 1;
						$.each(v.body, function(ii,vv){
							new_data[i][num] = vv;
							num++;
						})
					})
					drawBasic(new_data);
					return new_data;
				}
			})
		}
		
		function drawBasic(include_data = []) {
			var data = new google.visualization.DataTable();
			var options = {
			  title: 'Placeholder title',
			  hAxis: {
				title: 'Time'
			  },
			  vAxis: {
				title: 'Temp'
			  }
			};
			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

			data.addColumn('datetime', 'Date');
			data.addColumn('number', 'Current');
			data.addColumn('number', 'Target');
			console.log(include_data);

			data.addRows(
			  include_data
			);

			chart.draw(data, options);
		}
	})()
</script>

@endsection