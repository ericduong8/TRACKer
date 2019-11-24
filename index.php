<?php
if (isset($_POST['submit'])) {
    $allowedExts = array("mp4");
    $extension = pathinfo($_FILES["base_file"]['name'], PATHINFO_EXTENSION);
    if ($_FILES["base_file"]["type"] == "video/mp4") {
        if ($_FILES["base_file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["base_file"]["error"] . "<br />";
        }
        else {
            move_uploaded_file($_FILES["base_file"]["tmp_name"],"videos/base-video.mp4");
        }
        header("Location: response.php");
    }
    $extension = pathinfo($_FILES["compare_file"]['name'], PATHINFO_EXTENSION);
    if ($_FILES["compare_file"]["type"] == "video/mp4") {
        if ($_FILES["compare_file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["compare_file"]["error"] . "<br />";
        }
        else {
            move_uploaded_file($_FILES["compare_file"]["tmp_name"],"videos/compare-videos.mp4");
        }
    }
}
?>




<html>

<head>
    <title>TRACKer</title>
    <link href = "index.css" rel = "stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dosis:800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300&display=swap" rel="stylesheet">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous">
    </script>
</head>

<body>
<h1 class = "title">TRACKer</h1>

<div class="custom-select" style="width:200px; margin-left: 8.23%; margin-bottom: 30px;">
    <select id = "examples">
        <option class = "options" value="">Select sport:</option>
        <option class = "options" value="sprints.mp4">Sprints</option>
        <option class = "options" value="distance.mp4">Distance</option>
        <option class = "options" value="long_jump.mp4">Long Jump</option>
        <option class = "options" value= "triple_jump.mp4">Hurdles</option>
        <option class = "options"  value= "shotput.mp4">Shotput</option>
    </select>
</div>

<div class = "half-screen">

    <video class = "video-holder" id = "base-video" controls></video>

</div>

<div class = "half-screen" style = "margin-right: 0px;">

    <video class = "video-holder" id = "compare-video" style = "float: left;" controls></video>

</div>

<form action="index.php" method="POST" enctype="multipart/form-data">
    <div style = "float: left;">

        <input type = "submit" class = "pretty-upload" style = "left: 8.2%;" id = "fake-base" value = "Input Base Video">
        <input type = "file" id = "base-file" name = "base_file" class = "file-upload">

    </div>

    <div style = "float: right;">

        <input type = "submit" class = "pretty-upload" style = "right: 8.2%;" id = "fake-compare" value = "Input Comparison Video">
        <input type = "file" name = "compare_file" id = "compare-file" class = "file-upload">

    </div>

    <input type = "hidden" id = "example-path" name = "example-path" value = "">
    <input type = "submit" class = "pretty-upload" id = "submit" name = "submit">

    <script>
        $(document).on("change", "#base-file", function(evt) {
            var $source = $('#base-video');
            $source[0].src = URL.createObjectURL(this.files[0]);
            $source.parent()[0].load();
        });

        $(document).on("change", "#compare-file", function(evt) {
            var $source = $('#compare-video');
            $source[0].src = URL.createObjectURL(this.files[0]);
            $source.parent()[0].load();
        });

        $("#fake-base").click(function(e){
            e.preventDefault();
        });

        $("#fake-compare").click(function(e){
            e.preventDefault();
        });
    </script>

</form>
<script src = "index.js"></script>

</body>

</html>