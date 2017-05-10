@extends('master')

@section('breadcrumb')
    <p class="navbar-text"><a href="{{url('/')}}">Home</a></p>
@endsection

@section('body')
    <div class="container">
        <h1>IoT Home</h1>
        <div class="panel col-md-4">
            <div class="panel-body clearfix">
                <span class="m-0 clearfix weather-location-name"></span>
                <h1 class="m-0 pull-left weather-temp"></h1>
                <h1 class="m-0 pull-right weather-icon"></h1>
            </div>
        </div>
        <div class="panel col-md-4">
            <div class="panel-body">
            </div>
        </div>
        <div class="panel col-md-4">
            <div class="panel-body">
                hello
            </div>
        </div>

    </div>
@endsection

@section('fab')
    <div class="fab-main" onclick="location.href='{{url('/device/create')}}'"><i class="glyphicon glyphicon-plus"></i></div>
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

    <script>
        weather = {
            '01d': 'weather-sunny',
            '02d': 'weather-partlycloudy',
            '03d': 'weather-cloudy',
            '04d': 'weather-cloudy',
            '09d': 'weather-rainy',
            '10d': 'weather-pouring',
            '11d': 'weather-lightning',
            '13d': 'weather-snowy',
            '50d': 'weather-fog',
            '01n': 'weather-sunny',
            '02n': 'weather-partlycloudy',
            '03n': 'weather-cloudy',
            '04n': 'weather-cloudy',
            '09n': 'weather-rainy',
            '10n': 'weather-pouring',
            '11n': 'weather-lightning',
            '13n': 'weather-snowy',
            '50n': 'weather-fog',
        }
        $.ajax({
            url: 'http://api.openweathermap.org/data/2.5/weather?q=Bournemouth&units=metric&appid=0d24835b37f71fea0cc1a5325c2b17cc',
            success: function(data){
                console.log(data);
                $('.weather-location-name').text(data.name);
                $('.weather-temp').html(Number((data.main.temp).toFixed(0)) + '&deg;C');
                $('.weather-icon').html($('<i>',{class:'mdi mdi-'+weather[data.weather[0].icon]}));
                console.log(weather[data.weather[0].icon])
                console.log(data.weather[0].icon)
                console.log(data.weather[0])
            }
        })
    </script>
@endsection