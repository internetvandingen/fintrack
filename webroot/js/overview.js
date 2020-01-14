    var barChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: []
    };


function parse_data(data){
        let result = {};
        for (let ii = 0; ii < data.length; ii++) {
            let value = data[ii];
            let key = value["name"];
            if (!result.hasOwnProperty(key)){
                result[key] = {label: key, backgroundColor: '#'+value["color"], data: new Array(12).fill(0)};
            }
            // add amount to correct month
            let month_index = value["month"]-1; // month values are 1-12
            result[key]["data"][month_index] += parseFloat(value["amount"]);
        }
    return(result);
}

function update_page(raw_data) {
        let parsed = parse_data(raw_data);

        // update chart
        barChartData.datasets = [];
        for (let k in parsed) {
            if (parsed.hasOwnProperty(k)) {
               barChartData.datasets.push(parsed[k]);
            }
        }
        window.myBar.update();

        // update table
        let table = "";
        for (let key in parsed){
            if (parsed.hasOwnProperty(key)) {
                table += "<tr><td><font color='"+parsed[key]['backgroundColor']+"'>&block;</font> "+key+"</td>";
                let data = parsed[key]['data'];
                for (let ii = 0; ii<data.length; ii++) {
                    table += "<td>&euro;" + data[ii].toFixed(2) + "</td>";
                }
                table += "</tr>";
            }
        }
        $('#month tbody').html(table);
}

window.onload = function() {
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

    $.getJSON("/transactions/api/2020").done(update_page);
    $('#year').change(function(){
        let year = $(this).val()
console.log(year);
        $.getJSON("/transactions/api/"+year).done(update_page);
    });
};





