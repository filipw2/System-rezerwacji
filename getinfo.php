<!DOCTYPE html>
<html>
<head>
<style>

</style>
</head>
<body>

<?php
$q = intval(htmlentities($_GET['q']));

$con = mysqli_connect("149.156.136.151", "fwisniowski", "superhaslo","fwisniowski")or
    die("Connection failed: ");

    mysqli_set_charset($con,"utf8");
try{
    
    $sql="SELECT departure_date,f.route_id,economy_price,premium_price,business_price,flight_time FROM Flight f,Route r WHERE f.flight_number = '".$q."' and f.route_id=r.route_id" ;
    
    $result = mysqli_query($con,$sql);

    
    
    $row = mysqli_fetch_array ($result);
    $time=strtotime($row["departure_date"]);
    $flight_time=$row["flight_time"];
    $arrival_time=$time+(60*$flight_time);
    $route_id=$row["route_id"];
    
    $result2= mysqli_query($con, "select origin_airport_id,destination_airport_id from Route where route_id='{$route_id}';");
    $row2= mysqli_fetch_array ($result2);
    $origin_id=$row2['origin_airport_id'];
    $dest_id=$row2['destination_airport_id'];

    $result3=mysqli_query($con, "select city_name,airfield_name,code from Airfield a, City c where airfield_id='{$origin_id}' and a.city_id = c.city_id;");
   
    $oRow=mysqli_fetch_array ($result3);
    
    $result4=mysqli_query($con, "select city_name,airfield_name,code from Airfield a, City c where airfield_id='{$dest_id}' and a.city_id = c.city_id;");
    $dRow=mysqli_fetch_array ($result4);
    
    
    echo "<div >". date( 'd.m.Y', $time ) ."</div>
        <div  >".date( 'H:i', $time ) ." ".$oRow['city_name'] ." (".$oRow['code'].")</div>
        <div  >".date('H:i',$arrival_time)." ".$dRow['city_name']." (".$dRow['code'].")</div>";
    
    }
    catch(Exception $e)
    {
    }

    
    mysqli_close($con);
?>
</body>
</html>