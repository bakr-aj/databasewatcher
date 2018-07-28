<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DataBase Watcher</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
    <!-- <script src="main.js"></script> -->
    <script src="{{asset('vendor/bakraj/databasewatcher/assets/js/Chart.bundle.js')}}"></script>    
    <script src="{{asset('vendor/bakraj/databasewatcher/assets/js/jquery.min.js')}}"></script>    


</head>
<body>
    <script>
        var date = {!! json_encode($date)!!};
        var stats_data = {!! json_encode($data)!!};
    </script>
    <div style="text-align:center">
        <P>DataBase Watcher Statistics </P>
        <div style="width:500px;  display:inline-block">
           
            <canvas id="day">
            </canvas>
        </div>
        <div style="width:500px; display:inline-block">
            <canvas id="month">
            </canvas>
        </div>
        <div style="margin-top:3%">
            <select name="date" id="dates">
                <option selected disabled>select date</option>
                @foreach($data['dates']->dates as $date) 
                    <option>{{$date}}</option>
                @endforeach    
            </select>
        </div>
        
        <div style="width:500px; display:inline-block">
            <canvas id="date">
            </canvas>
        </div>

        <script src={{asset('vendor/bakraj/databasewatcher/assets/js/graph.js')}}> 
        </script>
    </div>
</body>
</html>