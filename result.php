<?php
include('base.php');
require_once('signature.php');

$query = mysqli_query($connection,"select City_name from City");
$city=array();
$i=0;
while ($row = mysqli_fetch_array ($query)){
    $city[$i++]= $row ['City_name'];
}

if ($_SERVER['REQUEST_METHOD']== "POST") 
    {
        if(!empty($_POST['DepartureCity']) && !empty($_POST['ArrivalCity']) && !empty($_POST['date']))
            if(($_POST['x']=='y' && !empty($_POST['date2'])) ||$_POST['x']=='z')
             
                foreach($_POST as $key => $field) 
                {
           
   
                    $field = test_input($field);

                setcookie($key,$field);
                }
        
        header("location:result.php");
            
    }


if(isset($_COOKIE['group1']))
    if(isset($_COOKIE['reservation_id']))
    {
        $r_id=$_COOKIE['reservation_id'];
       
        try{
  
            $result=mysqli_query($connection,"delete from Reservation  where is_confirmed is null and reservation_id='{$r_id}' and user_id= '{$idu}';");

        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        
       header("Refresh:0");
    }
//header("Cache-Control: no-store, no-cache, must-revalidate");  
//header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
//header("Pragma: no-cache");

$row_number=0;

if(isset($_COOKIE['reservation_id']))
    setcookie("reservation_id",0,time()-3600);


    //jesli nie wybrano miast to wyslij do index
if(empty($_COOKIE['DepartureCity']) || empty($_COOKIE['ArrivalCity']))
    header("location:index.php");

if(!empty($_COOKIE['DepartureCity']) && !empty($_COOKIE['ArrivalCity']) && !empty($_COOKIE['date']))
    if(($_COOKIE['x']=='y' && !empty($_COOKIE['date2'])) ||$_COOKIE['x']=='z')
    {   
        $date=$_COOKIE['date'];
        $date=strtotime(str_replace('/','-',$date));
        $dates= date('Y-m-d H:i:s', $date);
        $datee= date('Y-m-d H:i:s', strtotime($dates . ' +1 day'));
        
        $class=0;
        if(isset($_COOKIE['flight_class']))
            $class=$_COOKIE['flight_class'];
        
        $n2=1;
        $departure=test_input($_COOKIE['DepartureCity']);
        $arrival=test_input($_COOKIE['ArrivalCity']);
      
        try
        {
            $query=mysqli_query($connection,"select * from Flight f,Route r,Airfield a,City c where
                c.City_name='$departure' and f.departure_date>'$dates' and f.departure_date<'$datee' and a.city_id=c.city_id and r.origin_airport_id=a.airfield_id and f.route_id=r.route_id and r.destination_airport_id=(select airfield_id from Airfield , City where City.city_name ='$arrival' and City.city_id=Airfield.city_id);");
            
            if( !$query )
                throw new Exception($connection->error);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        if($_COOKIE['x']=='y')
        {
            
            $date2=$_COOKIE['date2'];
            $date2=strtotime(str_replace('/','-',$date2));
            $date2s= date('Y-m-d H:i:s', $date2);
            $date2e= date('Y-m-d H:i:s', strtotime($date2s . ' +1 day'));
            
            try
            {
                
                $query2=mysqli_query($connection,"select * from Flight f,Route r,Airfield a,City c where
                    c.City_name='$arrival' and f.departure_date>'$date2s' and f.departure_date<'$date2e' and a.city_id=c.city_id and r.origin_airport_id=a.airfield_id and f.route_id=r.route_id and r.destination_airport_id=(select airfield_id from Airfield , City where City.city_name ='$departure' and City.city_id=Airfield.city_id);");
            
                if( !$query2 )
                    throw new Exception($connection->error);
                
                $n2=0;
           
                $n2=mysqli_num_rows($query2);
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
            }
        }
        
        $n1=mysqli_num_rows($query);
            
        $person_number=0;
        if(isset($_COOKIE['person_number']))
            $person_number=$_COOKIE['person_number'];
        
        $price=0;
?>


    <div  id="container2" class="container w3-card-4  w3-white" style="min-height:1000px;padding-top:100px">
        <div class="row" style="padding:10px 15px 15px 15px;margin-bottom:20px;">
            <div>
                <button onclick="toggle()" class=" w3-blue w3-card-2" style="width:100%;height:36px;border:0 solid black;">Zmień</button>
            </div>
        
            <form method="post" action="" class=""> 
     
                <div id="Flight"  class="container w3-white w3-padding-16 col-sm-12 w3-card-2" style="display:none;min-width:400px; ">
                     
 
                    <div class="w3-row-padding" style="margin:0 -16px;">
    
                        <table style="width:100%">
                            <tr>
                                <td style="width:46%">
                                    <label>Z</label>
                                    <select class="w3-input w3-border klikniecie" id="DepartureCity" name="DepartureCity" placeholder="Departing from">

                                        <option disabled selected value> Wybierz miasto </option>
                                        <?php foreach($city as $c){?>
                                        <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                        <?php
                                                                  }
                                        ?>

                                    </select>
                                </td>
                                <td style="width:5%">

                                    <button 
                                            type="button"  onclick="switchCity()"  style="padding=10px 10px;width=10px;background-color:transparent; margin-top:20px"
                                            >
                                        <img src="switch.jpg" alt="Submit" width="100%" ></button>
                                </td>
                                <td style="width:46%">
                                    <label>Do</label>

                                    <select class="w3-input w3-border klikniecie"  id="ArrivalCity" placeholder="Arriving at"  name="ArrivalCity" >
                                        <option disabled selected value> Wybierz miasto </option>
                                        <?php foreach($city as $c){?>
                                        <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                        <?php
                                                                  }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <fieldset>
                        <div class="some-class">
                            <input onclick="document.getElementById('date2').disabled = false;" type="radio" class="radio" name="x" value="y" id="y" checked="checked"/>
                            <label for="y">Lot w obie strony</label>
                            <input onclick="document.getElementById('date2').disabled = true;" type="radio" class="radio" name="x" value="z" id="z" />
                            <label for="z">Lot w jedną stronę</label>
                        </div>
                    </fieldset>

                    <div class="w3-row-padding" style="margin:0 -16px;">
                        <table style="width:100%">
                            <tr>
                                <td style="width:25%">
                                    <label>Data wylotu: </label><input type="text" id="date" name="date" class ="w3-input w3-border klikniecie">
                                    <script>$('#date').datepicker({minDate: 0, dateFormat: 'dd/mm/yy'});</script>
                                </td>
                                <td style="width:25%">
                                    <label>Data powrotu: </label><input type="text" id="date2" name="date2" class ="w3-input w3-border klikniecie" style="border-radius:5px" >
                                    <script>$('#date2').datepicker({
                                            minDate:0,
                                            onSelect: function (date) {
                                                var date1 = $('#date').datepicker('getDate');           
                                                var date = new Date( Date.parse( date1 ) ); 
                                                date.setDate( date.getDate() + 1 );        
                                                var newDate = date.toDateString(); 
                                                newDate = new Date( Date.parse( newDate ) );                      
                                                $('#date2').datepicker("option","minDate",newDate);  
                                            }
                                            , dateFormat: 'dd/mm/yy'});</script>
                                </td>
                                <td style="width:25%">
                                    <label>Liczba osób: </label><input type="number" id="person_number" name="person_number" class ="w3-input w3-border klikniecie" min="1" max="300" value="1">
                                </td>
                                <td style="width:25%">
                                    <label>Klasa podróży: </label><select class ="w3-input w3-border klikniecie" name="flight_class" id="flight_class">
                                    <option value="0">Economy</option>
                                    <option value="1">Premium</option>
                                    <option value="2">Business</option>
                                    </select>
                                </td>
                            </tr></table>
                    </div>
         
                    <input name="search2" type="submit" value="Szukaj" class="w3-input w3-btn w3-blue" style="float:right;width:22%;margin:1%"  
                   onclick="">
       
                </div>
            </form>      
           
        </div>
        <div class="row"> 
            <form method="post" action="seat.php" class=""> 
                
                <div id="left2" class="col-sm-9 ">
                    <div class="20p table-responsive" style="">
                
                       
                        <table class="w3-card-2 table table-striped table-bordered table-hover table-condensed"  style="width:100%;background-color:white;margin-left:auto;margin-  right:auto;padding: 0 2em;z-index:5;">
                            <thead>
                                <tr>
                                    <caption  class="w3-blue caption_padding" style="padding-left:10px;">
                                        <?php echo date('d.m.Y', $date)."&nbsp&nbsp<b>".$_COOKIE['DepartureCity'] . " --> " . $_COOKIE['ArrivalCity']."</b>";?>
                                    </caption> 
                                </tr>
                    <?php
        $i=0;
            
        if($n1>0)
        {
                    ?>
                           
                            <tr>

                                <th style="width:20%"><b>Wylot</b></th>
                                <th><b>Przylot</b></th>
                                <th><b>Lot</b></th>
                                <th><b>Cena</b></th>
                                <th></th>
                            </tr>
                        </thead> 
                        <tbody>
                    <?php 
           
            $price=array();
            $time=array();
            
            $arrival_time=array();
                       
            while ($row = mysqli_fetch_array ($query))
            {
                $row_number++;
                $f_number=$row["flight_number"];
                $time[$f_number]=strtotime($row["departure_date"]);
                $flight_time=$row["flight_time"];
                $msg="";
                try
                {
                    $fQuery=mysqli_query($connection,"select freeplace($f_number,$class) as number;");
                    if(!$fQuery)
                        throw new Exception($connection->error);
                    $free=mysqli_fetch_assoc($fQuery);
                    $msg=$free['number'];
                    if($free['number']==0)
                        $msg=" Brak miejsc";
                    else if($free['number']<$person_number)
                        $msg=" Nie ma tyle miejsc";
                }
                catch(Exception $e)
                {
                    
                }
                $arrival_time[$f_number]=$time[$f_number]+(60*$flight_time);
                       // $arrival_time=date('H:i:s',strtotime('+59 minutes', date( 'H:i:s', $time )));

                        ?>

                          <tr style="height:60px;margin:10px 10px 10px 10px;">

                            <td style=""><?php echo date( 'H:i', $time[$f_number] );?></td>
                            <td><?php echo date('H:i',$arrival_time[$f_number]);?></td>
                            <td><?php echo $f_number ?></td>
                            <td><?php 
                           
                            switch($class){
                                case 0: $price[$row["flight_number"]]=$row["economy_price"];break;
                                case 1: $price[$row["flight_number"]]=$row["premium_price"];break;
                                case 2: $price[$row["flight_number"]]=$row["business_price"];break;
                                }
                            echo $price[$row["flight_number"]] . "zł";
                        ?>
                              </td>


                              <td><input type="checkbox" onchange="showFlight(this.value,'doP');getPrice(this.value,'doP');showMe('doP','group1[]');" class="radio" value="<?php echo $row['flight_number']?>" name="group1[]"/><?php echo $msg;?></td>
                          </tr>
                            
                    <?php };?>
                            
                   
            <?php
                    }
                    else
                    {?>
                     </thead> 
                        <tbody>
                        
                           <tr style="height:60px;"><td><h3>Brak lotów na tej trasie dnia <?php echo date('d.m.Y', $date);?></h3></td></tr>  
                        
                        
               
                       
            <?php     }
                ?>
                 </tbody>
                    </table>
                </div> 

            <?php if($_COOKIE['x']=='y')
            {

            ?>        
                <div class="table-responsive" style="margin-top:50px;">
                    
                    <table class="w3-card-2 table table-striped table-bordered table-hover table-condensed"  style="width:100%;background-color:white;margin-left:auto;margin-right:auto;padding: 0 2em;z-index:5;">
                       <thead>
                           <tr>
                              <caption  class="w3-blue caption_padding" style="padding-left:10px;">
                                     <?php echo date('d.m.Y', $date2)."&nbsp&nbsp<b>".$_COOKIE['ArrivalCity'] . " --> " . $_COOKIE['DepartureCity']."</b>   ";?>
                               </caption> 
                           </tr>
                        
                    <?php
        if($n2>0)
        {
                    ?>
                        
                        <tr>
                            <th style="width:20%"><b>Wylot</b></th>
                            <th><b>Przylot</b></th>
                            <th><b>Lot</b></th>
                            <th><b>Cena</b></th>
                            <th></th>
                        </tr>
                        </thead> 
                        <tbody>
                    <?php 
                
            while ($row = mysqli_fetch_array ($query2)){
                       
                $f_number=$row["flight_number"];
                $time[$f_number]=strtotime($row["departure_date"]);
                $flight_time=$row["flight_time"];
                $arrival_time[$f_number]=$time[$f_number]+(60*$flight_time);
                $msg="";
                try
                {
                    $fQuery=mysqli_query($connection,"select freeplace($f_number,$class) as number;");
                    if(!$fQuery)
                        throw new Exception($connection->error);
                    $free=mysqli_fetch_assoc($fQuery);
                    
                    if($free['number']==0)
                        $msg=" Brak miejsc";
                    else if($free['number']<$person_number)
                        $msg=" Nie ma tyle miejsc";
                }
                catch(Exception $e)
                {
                    
                }
                        ?>

                          <tr style="height:60px;margin:10px 10px 10px 10px;">

                            <td style=""><?php echo date( 'H:i', $time[$f_number] )?></td>
                            <td><?php echo date('H:i',$arrival_time[$f_number]);?></td>
                            <td><?php echo $row["flight_number"]?></td>
                            <td> 
                                <?php switch($class){
                                case 0: $price[$row["flight_number"]]=$row["economy_price"];break;
                                case 1: $price[$row["flight_number"]]=$row["premium_price"];break;
                                case 2: $price[$row["flight_number"]]=$row["business_price"];break;
                                }
                            echo $price[$row["flight_number"]] . "zł";
                        ?>
                              </td>

                              <td><input type="checkbox"  onchange="showFlight(this.value,'zP');getPrice(this.value,'zP');showMe('zP','group2[]')" class="radio" name="group2[]" value="<?php echo $row['flight_number']?>"/><?php echo $msg;?></td>
                          </tr>
                            
                    <?php };?>
                            
                   
            <?php
                    }
                    else
                    {?>
                     </thead> 
                        <tbody>
                        
                         <tr style="height:60px;"><td><h3>Brak lotów na tej trasie dnia <?php echo date('d.m.Y', $date2);?></h3></td></tr>   
                        
                        
               
                       
            <?php     }
                ?>
                 </tbody>
                    </table>
                </div> 


            <?php } ?>
         
<!--
                <div class="" style="margin-top:50px;">

                    <button type="button" onClick="location.href='index.php'"  style="float:left;" name="back">Wstecz</button>

                   <button type="submit" style="float:right;" id ="next" name="next">Dalej</button>

                </div>-->
            </div>
            <div id="right3"  class="col-sm-3">
                
                <div  class="20p table-responsive w3-card-2" >
                
                    <div id="caption" class="w3-blue caption_padding" style="padding: 8px 10px 8px 10px;">
                        Bilety lotnicze
                    </div>
                      
                    <div id="doP" style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;display:none">
                        
                    </div>
                    
                    <div id="zP"  style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;display:none">
               
                    </div>
                    
                    <div id="pas" style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;">
                   <span></span>
                        <div><?php 
                            
                            echo "Liczba pasażerów: ". $person_number?></div>
                        <div></div>
                    </div>
                    
                    <div id="butN" style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;">
                        <div id="price"><?php 
                                echo "Do zapłaty: 0"
                            ?></div>
                        <button type="submit" onclick="createCookie('price',pricev(),1)"class="w3-input w3-btn w3-blue" style="margin-top:30px" id ="next" name="next">Dalej</button>
                    </div>
               <!--     <table class="w3-card-2 table"  style="width:100%;background-color:white;margin-top:10px;margin-left:auto;margin-right:auto;padding: 0 2em;z-index:5;">
                <thead>
                           <tr>
                              <caption  class="w3-blue caption_padding" style="padding-left:10px;">
                              Bilety lotnicze
                               </caption> 
                           </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>asd</td>
                           
                            </tr>
                            <tr>
                                <td>asd</td>
                           
                            </tr>
                            <tr>
                                <td>asd</td>
                           
                            </tr>
                            <tr>
                                <td>asd</td>
                           
                            </tr>
                        </tbody>
                                            
                        
                    </table>
            -->
                
                </div>
            </div>   
        </form>
    </div>

            

<script>
    
    var n1 = <?php echo $n1;?>;
    var n2 = <?php echo $n2;?>;
                
    if(n1==0 & n2==0)
        document.getElementById('next').disabled=true;
          
    
    $('input[type="checkbox"]').on('change', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
                $(this).prop('checked', true);
                });
 
    
    function showMe (box,name) 
    {

        var chboxs = document.getElementsByName(name);
        var vis = "block";
        for(var i=0;i<chboxs.length;i++) 
        { 
            if(chboxs[i].checked)
            {
             vis = "block";
                break;
            }
        }
                
        document.getElementById(box).style.display = vis;

    }

            
            
    function getPrice(str,div)
    {
        var words = <?php echo json_encode($price) ?>;
        var p=<?php echo $person_number?>;
                
        if(div=="zP")
            price1=words[str]*p;
        if(div=="doP")
            price2=words[str]*p;
                
        price=price1+price2;
                
        document.getElementById("price").innerHTML="Do zapłaty: "+price+" zł";
        
    }
    
    
            
    function createCookie(name,value,days) 
    {
        var expires = "";
        if (days) 
        {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function pricev(){
        return price1+price2;
    }

    function readCookie(name) 
    {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) 
        {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length,c.length);
        }
        
        return null;
    }

    function eraseCookie(name) 
    {
   
        createCookie(name,"",-3600);
  
    }
    function toggle() 
    {
        var x = document.getElementById('Flight');
        
        if (x.style.display === 'none') 
        {
            x.style.display = 'block';
        } 
        else 
        {
            x.style.display = 'none';
        }
    }
    $('form :submit').click( function () {
    $(this).prop("disabled", true).closest('form').append($('<input/>', {
        type: 'hidden',
        name: this.name,
        value: this.value
    })).submit();
});
</script>
    
    </body>
</html>
        <?php
        
    }
    else
    {
        
        header("location: error.php?result=0");
exit;
    }
ob_flush();
?>