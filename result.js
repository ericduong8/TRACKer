// total error
var request = new XMLHttpRequest();
var url = "http://localhost:5000/totalerror";

request.open("GET", url);

request.onload = function() {
    var similarity = this.response;
    similarity = (100 - parseFloat(similarity)*100).toFixed(2);
    document.getElementById('totalerror').innerHTML = similarity + "<span class = 'second' style = 'color: rgba(255, 251, 244, 0.5); font-size: 80px;'>%</span>";
}

request.send();

// cumulative accuracy
var request = new XMLHttpRequest();
var url = "http://localhost:5000/continuouserror";

request.open("GET", url);

request.onload = function() {
    var result = JSON.parse(this.response);
    console.log(result["coords"]);
    var ycoords = [];
    var xcoords =  [];
    for (var i = 0; i < result["coords"].length; i++) {
        var x = "Time: " + (i*0.15).toFixed(2) + "s";
        xcoords.push(x);
        ycoords.push((result["coords"][i]).toFixed(2));
    }

    var ctx = document.getElementById('sentChart').getContext('2d');

    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: xcoords,
            datasets: [{
                backgroundColor: 'rgba(255, 255, 255, 0.4)',
                borderColor: 'white',
                borderWidth: 10,
                borderCapStyle: "round",
                pointBorderWidth: 0,
                pointRadius: 15,
                pointHoverRadius: 15,
                pointBackgroundColor: 'rgba(255,255,255,0.5)',
                pointHoverBackgroundColor: 'rgba(255,255,255,0.5)',
                pointBorderColor: 'rgba(255,255,255,0)',
                data: ycoords
            }]
        },
        options: {
            legend: {
                display: false
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 20,
                    bottom: 20
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontColor: "transparent",
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: "transparent"
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    }
                }]
            }
        }
    });
}

request.send();

// load error frames
var request = new XMLHttpRequest();
var url = "http://localhost:5000/framenumbers";

request.open("GET", url);

request.onload = function() {
    var obj = JSON.parse(this.response);

    var framesArray = obj.frames;
    var length = framesArray.length;
    var errorValues = [];
    var imageNames = [];
    var times = []

    for (var i = 0; i < length; i++){
        errorValues.push(framesArray[i].error);
        imageNames.push(framesArray[i].name);
        times.push(framesArray[i].timestamp)
    }

    for (var i = 0; i < errorValues.length; i++) {
        basename = "images/base-videos/" + imageNames[i];
        comparename = "images/compare-videos/" + imageNames[i];

        document.getElementById("left").innerHTML +=
            "<div class = 'pose-image'>" +
            "<img src = '" + basename + "' width = 100%>" +
            "<p style='text-align: right;'>" +
            "<span class = 'small-text'>Error: " + (errorValues[i]*100).toFixed(2) + "%</span><br>" +
            "<span class = 'small-text'>Timestamp: " + times[i].toFixed(2) + "s</span>" +
            "</p>" +
            "</div>";
        document.getElementById("right").innerHTML +=
            "<div class = 'pose-image'>" +
            "<img src = '" + comparename + "' width = 100%>" +
            "<p style='text-align: right;'>" +
            "<span class = 'small-text'>Error: " + (errorValues[i]*100).toFixed(2) + "%</span><br>" +
            "<span class = 'small-text'>Timestamp: " + times[i].toFixed(2) + "s</span>" +
            "</p>" +
            "</div>";
    }
}

request.send();
