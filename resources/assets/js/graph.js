
function draw (stats,element){
    var ctx = element;
    var option = {"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}};
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: stats,
        option: option
    });

}

var json = stats_data['date'];
var chart_label = "request/hour: "+date; //key.match("[0-9]{4}-[0-9]{2}-[0-9]{2}");
var total;
var labels = [];
var chart_data = [];
var stats = json;
for(key in stats)
{
    total =  stats[key]['total'];
    var hour_request =  stats[key]['hour_request'];
    for(key in hour_request)
    {
        labels.push(key);
        chart_data.push(hour_request[key]);
    }
    
}

var data = {
    "labels" : labels,
    "datasets" : [{
        "label" : chart_label,
        "data":chart_data,
        "fill":false,
        "borderColor":"rgb(75, 192, 192)",
        "lineTension":0.1
    }]
};

var element = document.getElementById("day");

draw(data,element);

var json = stats_data['overall'];
var chart_label = "request/day: all the time"; //key.match("[0-9]{4}-[0-9]{2}-[0-9]{2}");
var labels =[];
var chart_data = [];
var stats = json.stats;
for(key in stats)
{
    labels.push(key);
    chart_data.push(stats[key]['total']);
}

var data = {
    "labels" : labels,
    "datasets" : [{
        "label" : chart_label,
        "data":chart_data,
        "fill":false,
        "borderColor":"rgb(75, 192, 192)",
        "lineTension":0.1
    }]
};

var element = document.getElementById("month");

draw(data,element);


$('#dates').change(function(){

    var date = this.value;
    var url = '/databasewatcher/analyze/' + date;

    $.getJSON(url).done(function( json ){
        var chart_label = "request/hour: "+date; //key.match("[0-9]{4}-[0-9]{2}-[0-9]{2}");
        var total;
        var labels = [];
        var chart_data = [];
        var stats = json;
        for(key in stats)
        {
            
            total =  stats[key]['total'];
            var hour_request =  stats[key]['hour_request'];
            for(key in hour_request)
            {
                labels.push(key);
                chart_data.push(hour_request[key]);
            }
            
        }

        var data = {
            "labels" : labels,
            "datasets" : [{
                "label" : chart_label,
                "data":chart_data,
                "fill":false,
                "borderColor":"rgb(75, 192, 192)",
                "lineTension":0.1
            }]
        };

        var element = document.getElementById("date");
        
        draw(data,element);
    });
});