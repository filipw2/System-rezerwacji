 <script src="http://html2canvas.hertzen.com/build/html2canvas.js"></script>
<?php
include('base.php');
require_once('signature.php');



?>

<style>
.form .button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #2196F3;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
    .button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #2196F3;
  
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
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
    label
    {
        float:none;
    margin-left: 0;
    }
</style>
<?php
    if ($_SERVER['REQUEST_METHOD']== "POST"){
        if(!empty($_POST['nazwisko']) && !empty($_POST['number']))
        {
            $reservation_id=test_input($_POST['number']);
            $surname=htmlspecialchars(addslashes($_POST['nazwisko']));
            $i=1;
            $resultTime=mysqli_fetch_assoc(mysqli_query($connection,"select reservation_timestamp from Reservation where reservation_id='{$reservation_id}';"));
            
            $query=mysqli_query($connection,"select seat_reserved_id,flight_id,n.namee,p.assist,p.title from Seat_reserved s,Passenger p, Namee n, Surname u where u.surname_id=p.surname and n.name_id=p.name and reservation_id='{$reservation_id}' and p.person_id=s.passenger_id and u.surname='{$surname}';");
             
            

    $rn=mysqli_num_rows($query);
    
            echo $surname;
    while($seats = mysqli_fetch_array($query))
    {
         $sql="SELECT departure_date,f.route_id,economy_price,premium_price,business_price,flight_time FROM Flight f,Route r WHERE f.flight_number = '".$seats['flight_id']."' and f.route_id=r.route_id" ;
    
        $result = mysqli_query($connection,$sql);
        $row = mysqli_fetch_array ($result);
        $time=strtotime($row["departure_date"]);
        $flight_time=$row["flight_time"];
        $arrival_time=$time+(60*$flight_time);
        $route_id=$row["route_id"];

        $result2= mysqli_query($connection, "select origin_airport_id,destination_airport_id from Route where route_id='{$route_id}';");
        $row2= mysqli_fetch_array ($result2);
        $origin_id=$row2['origin_airport_id'];
        $dest_id=$row2['destination_airport_id'];

        $result3=mysqli_query($connection, "select city_name,airfield_name,code from Airfield a, City c where airfield_id='{$origin_id}' and a.city_id = c.city_id;");

        $oRow=mysqli_fetch_array ($result3);

        $result4=mysqli_query($connection, "select city_name,airfield_name,code from Airfield a, City c where airfield_id='{$dest_id}' and a.city_id = c.city_id;");
        $dRow=mysqli_fetch_array ($result4);

            ?>

<div style="opacity: 0.0;">
    <div id="html-content-holder<?php echo $i;?>" style="position:fixed;top:<?php $f=$i*3;echo $f."00";?>px;background-color:white;width:600px;height:300px;border-radius:20px;">
            <img src="code.png" width="230px" style="position:fixed;left:360px;top:<?php $f=$i*3;echo $f."35";?>px;">
        <table class="board" style="width:600px;height:300px;border: 1px solid black;border-spacing:0;border-radius:20px;z-index:10">
            <tr>
                <td class="w3-blue" style="border-radius: 20px 0 0 0;text-align:center;">PAIrways</td>
                <td>BOARDING PASS</td>
                <td></td>
            </tr>
            <tr>
                <td><label for="a">TRAVEL DATE</label><div name="a"><?php echo date( 'd.m.Y', $time ); ?></div></td>
                <td><label for="a">FROM</label><div name="a"><?php echo $oRow['city_name']; ?></div></td>
                <td></td>
            </tr>
            <tr>
                <td><label for="a">FLIGHT NUMBER</label><div name="a"><?php echo $seats['flight_id'];?></div></td>
                <td><label for="a">TO</label><div name="a"><?php echo $dRow['city_name']; ?></div></td>
                <td style="text-align:right;padding-right:30px;"><?php  echo $reservation_id;?></td>
            </tr>
            <tr>
                <td><label for="a">GATE CLOSES</label><div name="a"><?php echo date('H:i', strtotime('-30 minutes',$time)); ?></div></td>
                <td><label for="a">FLIGHT DEPARTS</label><div name="a"><?php echo date( 'H:i', $time ); ?></div></td>
                <td></td>
            </tr>
            <tr>
                <td style="border-bottom:0;"><label for="a">SEAT NUMBER</label>
                    <div name="a"><?php echo $seats['seat_reserved_id']; ?></div>
                </td>
                <td><label for="a">PASSENGER</label><div name="a"><?php echo ($seats['title']==1 ? "Pan " : "Pani ") . $seats['namee'] . " " . $surname;?></div></td>
                <td> </td>
            </tr>
        </table> 
    </div>
</div>
     

<!--

-->
        <?php   
        $i++;
    }?>
<div  id="container2" class="container w3-card-4  w3-white profil" style="min-height:1000px;padding-top:100px;">
    <div style="border-bottom: 3px solid #ddd;margin: 20px 0 30px 0">Zarządzanie rezerwacją numer: <?php echo $reservation_id;?></div>
    <div class="row" style=""> 
                 
        <div class="col-md-12" style="margin:0 130px 0 130px">
             
            <div class="col-xs-4">
                Informacje:    
            </div>
            <div class="col-xs-8">
                a
            </div>
            <div class="col-xs-4">
                Karta pokładowa lot 1: 
            </div>
            <div class="col-xs-8">
                <input class="button" id="btn-Preview-Image1" onclick="a(1);" type="button" value="Podgląd">
            </div>
            <div  style="display:none;" id="previewImage1" >
                    
            </div>
            <?php if($rn==2)
            echo '<div class="col-xs-4">
            Karta pokładowa lot 2: 
            </div>
                <div class="col-xs-8">
                    <input class="button" id="btn-Preview-Image2" onclick="a(2);" type="button" value="Podgląd">
                </div>
                <div  style="display:none;" id="previewImage2" ></div>';?>
        
        </div>   
    </div>
    
    
    
</div>  
            
  <?php          
        }
        
    }else{
?>
<header class="w3-display-container  " style="">
  <img class="w3-image" src="tropical-island2.jpg" alt="Island" style=" width:100%;object-fit: cover;min-height:700px;max-height:1400px;margin-top:54px;">
    <div class="w3-display-middle w3-white w3-card-8" style="top:40%;">
        <form id="form" action="" method="post">
    
            <div class="container " style="padding:15px 15px 15px 15px;margin:10px 0 10px 0">
                <div class="row">
                    <div class="col-sm-3">
                        Podaj nazwisko oraz numer rezerwacji
                    </div>
                    <div class="col-sm-3">
                        <label for="email">NAZWISKO</label>
                        <input class=" form-control" type="text" name="nazwisko" id="nazwisko"></div>
                    <div class="col-sm-3">
                         <label for="number">NUMER REZERWACJI</label>
                        <input class="col-sm-3 form-control" type="text" name="number" id="number">
                    </div>
                    <div class="col-sm-3 form">
                        <div style="visibility:hidden">A</div>
                        <input class="button" name="submit" type="submit" value=" Szukaj ">
                    </div>
                
                </div>            
            </div>
                        
        </form>
    </div>

<?php
    }
?>
        <script>
            var v=0;
            var b=0;
function a(number){       
    var div = number == 1 ? 'previewImage1' : 'previewImage2';
    
    var x = document.getElementById(div);
        
        if (x.style.display === 'none') 
        {
            x.style.display = 'block';
        } 
        else 
        {
            x.style.display = 'none';
        }
    if((v==0 && number == 1) || (b == 0 && number == 2)){
        if(number == 1)
            v=1;
        else
            b=1;
        var button = number == 1 ? 'html-content-holder1' : 'html-content-holder2';
        
        html2canvas(document.getElementById(button), {
  
            onrendered: function (canvas) {
        
        // document.getElementById('previewImage1').appendChild(canvas);
                var data = canvas.toDataURL('image/png');
        // AJAX call to send `data` to a PHP file that creates an image from the dataURI string and saves it to a directory on the server

                var image = new Image();
                image.src = data;
                document.getElementById(div).appendChild(image);
    }
});
    }
}
         
</script>
    
   
</body>
</html>