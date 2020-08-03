google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart1);
google.charts.setOnLoadCallback(drawChart2);
google.charts.setOnLoadCallback(drawChart3);
google.charts.setOnLoadCallback(drawChart4);
function drawChart1() {
    var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Total de Itens', 3],
        ['Finalizados', 5],
        ['Restante', 2]
    ]);

    var options = {
        pieHole: 0.3,
        backgroundColor: '#f3f6fb',
        chartArea:{left:5,top:20,width:'100%',height:'100%'},
        colors: ['#3366cc', '#69bd63', '#dc3912'],
    };

    var chart = new google.visualization.PieChart(document.getElementById('donutchart1'));
    chart.draw(data, options);
}

function drawChart2() {
    var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Total de Itens', 2],
        ['Finalizados', 3],
        ['Restante', 5]
    ]);

    var options = {
        pieHole: 0.3,
        backgroundColor: '#f3f6fb',
        chartArea:{left:5,top:20,width:'100%',height:'100%'},
        colors: ['#3366cc', '#69bd63', '#dc3912'],
    };

    var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
    chart.draw(data, options);
}

function drawChart3() {
    var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Total de Itens', 7],
        ['Finalizados', 1],
        ['Restante', 2]
    ]);

    var options = {
        pieHole: 0.3,
        backgroundColor: '#f3f6fb',
        chartArea:{left:5,top:20,width:'100%',height:'100%'},
        colors: ['#3366cc', '#69bd63', '#dc3912'],
    };

    var chart = new google.visualization.PieChart(document.getElementById('donutchart3'));
    chart.draw(data, options);
}

function drawChart4() {
    var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Total de Itens', 4],
        ['Finalizados', 3],
        ['Restante', 3]
    ]);

    var options = {
        pieHole: 0.3,
        backgroundColor: '#f3f6fb',
        chartArea:{left:5,top:20,width:'100%',height:'100%'},
        colors: ['#3366cc', '#69bd63', '#dc3912'],
    };

    var chart = new google.visualization.PieChart(document.getElementById('donutchart4'));
    chart.draw(data, options);
}