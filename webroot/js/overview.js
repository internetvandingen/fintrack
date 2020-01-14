window.onload = function() {
    var barChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: []
    };
    var ctx = document.getElementById('canvas').getContext('2d');
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
            title: {
                display: true,
                text: 'Monthly ledger results'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });

    $.getJSON("/transactions/api").done(function( data ) {
        let result = {};
        for (let ii = 0; ii < data.length; ii++) {
            let value = data[ii];
            let key = value["name"];
            if (!result.hasOwnProperty(key)){
// For now, insert random color but this should be changed to color from database
                result[key] = {label: key, backgroundColor: '#'+(Math.random()*0xFFFFFF<<0).toString(16), data: new Array(12).fill(0)};
            }
            // add amount to correct month
            let month_index = value["month"]-1; // month values are 1-12
            result[key]["data"][month_index] += parseFloat(value["amount"]);
        }
        barChartData.datasets = [];
        for (let k in result) {
            if (result.hasOwnProperty(k)) {
               barChartData.datasets.push(result[k]);
            }
        }
        window.myBar.update();

        // update table
        let table = "";
        for (let key in result){
            if (result.hasOwnProperty(key)) {
                table += "<tr><td>"+key+"</td>";
                let data = result[key]['data'];
                for (let ii = 0; ii<data.length; ii++) {
                    table += "<td>&euro;" + data[ii].toFixed(2) + "</td>";
                }
                table += "</tr>";
            }
        }
        $('#month tbody').html(table);
    });
};





