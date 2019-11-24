<?php

        $command = escapeshellcmd('C:\Users\Ethan\AppData\Local\Programs\Python\Python37\python.exe parse_video.py');
        $output = shell_exec($command);

        $command = escapeshellcmd('C:\Users\Ethan\AppData\Local\Programs\Python\Python37\python.exe pose_estimate.py');
        $output = shell_exec($command);

?>

<html>

    <head>
        <link href = "response.css" rel = "stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Dosis:800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Play&display=swap" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="logo.png"">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha38-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Catamaran:200,400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400" rel="stylesheet">

        <script src = "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>

    </head>

    <body>


        <div class = "container">
            <div style = "text-align: right;">
                <span class = "first">Total Accuracy</span>
                <br>
                <span class = "first2" >Cumulative Accuracy Through Time</span>
                <br>
                <span class = "second">
                    <span id = 'totalerror'></span>
                </span>
            </div>

            <canvas id = "sentChart" width = "100%" height = "60"></canvas>
            <hr class = "divider2">

            <div class = "scroll-container">
                <div id = "left" class = "pose-container">

                </div>

                <div id = "right" class = "pose-container">

                </div>
            </div>

        </div>



        <script src = "response.js"></script>
    </body>
</html>
