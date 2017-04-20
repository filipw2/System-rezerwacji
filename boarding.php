<?php


if ($_SERVER['REQUEST_METHOD']== "POST")
{
    
    
    
    $query=mysqli_query($connection,"select flight_number from Reservation where reservation_id = $reservation_id;");
    $flight_number=mysqli_fetch_assoc($query);
    
}


?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://files.codepedia.info/uploads/iScripts/html2canvas.js"></script>
    <style>
        .board td{
            width:200px;
            hieght:60px;
            padding: 5px 5px 5px 5px;
        }
        
        .board label{
            font-size:10px;
            color:blue;
        }
        
        .board  td:first-child{
           border-right: 2px solid black;
            border-bottom: 2px solid black;
            margin: 0 0 0 0;
        }
    </style>
</head>
<body>
    <div id="html-content-holder" style="background-color:white;width:600px;height:300px;border-radius:20px;">
        <img src="code.png" width="230px" style="position:fixed;left:360px;top:35px;">
<table class="board" style="width:600px;height:300px;border: 1px solid black;border-spacing:0;border-radius:20px;">
    <tr>
        <td>title</td>
        <td>BOARDING PASS</td>
        <td></td>
    </tr>
    <tr>
        <td><label for="a">TRAVEL DATE</label><div name="a">24 02 2017</div></td>
        <td><label for="a">FROM</label><div name="a">Warszawa</div></td>
        <td></td>
    </tr>
    <tr>
    <td><label for="a">FLIGHT NUMBER</label><div name="a">563</div></td>
        <td><label for="a">TO</label><div name="a">Londyn</div></td>
        <td style="text-align:right;padding-right:30px;">5434</td>
    </tr>
    <tr>
    <td><label for="a">GATE CLOSES</label><div name="a">15:00</div></td>
        <td><label for="a">FLIGHT DEPARTS</label><div name="a">15:30</div></td>
        <td></td>
    </tr>
    <tr>
    <td style="border-bottom:0;"><label for="a">SEAT NUMBER</label>
        <div name="a">113</div>
        </td>
        <td><label for="a">PASSENGER</label><div name="a">Pan Filip Wiśniowski</div></td>
        <td> </td>
    </tr>
    </table> 
        </div>
       <input id="btn-Preview-Image" type="button" value="Preview"/>
    <a id="btn-Convert-Html2Image" href="#">Download</a>
    <br/>
    <div id="previewImage" style="display:none">
    </div>
    
    <script>
$(document).ready(function(){
	
var element = $("#html-content-holder"); // global variable
var getCanvas; // global variable
 
    $("#btn-Convert-Html2Image").on('click', function () {
         html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
             }
         });
    });

	$("#btn-Convert-Html2Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "your_pic.png").attr("href", newData);
	});

});

</script>
</body>

</html>