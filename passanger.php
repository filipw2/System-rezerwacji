<?php
include('base.php');
require_once('signature.php');
setcookie("result",'1');

/*
if(!empty($_POST['group1'])) {
    $group1;
    foreach($_POST['group1'] as $check) {
            if(isset($check))$group1=$check;
    }
setcookie("group1",$group1);
}
if(!empty($_POST['group2'])) {
    $group2;
    foreach($_POST['group2'] as $check) {
            if(isset($check))$group2=$check;
    }
    setcookie("group2",$group2);
}
*/


if(isset($_COOKIE['group1']))
    $group1=test_input($_COOKIE['group1']);
else
    header("location:error.php?nogroup1=1");

if(isset($_COOKIE['group2']))
    $group2=test_input($_COOKIE['group2']);

if(isset($_COOKIE['price']))
    $price=test_input($_COOKIE['price']);

if ($_SERVER['REQUEST_METHOD']== "POST")
{
    if(isset($_COOKIE['reservation_id']))
     //   if(!isset($_COOKIE['p']))
            
    {
            foreach($_POST as $key => $field)
            {
               foreach((array)$field as $value)
                   $value = test_input($value);
            }
        
        session_start();
                
        
     try
     {
         
        $person_number=0; 
        $i=0;
        $result=array();
        $p_id=array(); 
        
        if(isset($_COOKIE['person_number']))
            $person_number=test_input($_COOKIE['person_number']);
   
         
        $connection->autocommit(false);

        $p_email=$_POST['p_email'];
        $r_id=test_input($_COOKIE['reservation_id']);
         
        $emailQ=mysqli_query($connection,"update Reservation set user_email='{$p_email}' where reservation_id='{$r_id}';");
       
        if ( !$emailQ ) 
        {
        throw new Exception($conn->error);
        }
         
        
        for(;$i<$_COOKIE['person_number'];$i++)
        {
   
            $p_name=stripslashes ($_POST['p_name'][$i]);
            $p_surname=stripslashes ($_POST['p_surname'][$i]);
            $p_asysta=0;
 
            if(!empty($_POST['p_asysta'][$i]))
                $p_asysta=$_POST['p_asysta'][$i];
      
            $p_title=$_POST['p_title'][$i];
   
   
            $result[$i]=mysqli_query($connection,"call addPassenger('".$p_name."','".$p_surname."','".$p_asysta."','".$p_title."',@p_id);");
   
            if ( !$result[$i] ) 
            {
                throw new Exception($conn->error);
            }
   
            $row=mysqli_fetch_assoc(mysqli_query($connection,"select @p_id;"));
            if( empty($row['@p_id']) || $row['@p_id']==null)
                throw new Exception("blad przy dodawaniu pasazera");
    
            $p_id[$i]=$row['@p_id'];
    
        
           // setcookie("p",1);
  
        }
       
    $connection->commit();
    $connection->autocommit(true);
        
    }
    catch( Exception $e ) 
    {
        $connection->rollback();
        mysqli_query($connection,"rollback;");
        header("location:error.php");
        $connection->autocommit(true);
    }
   
    try
    {
       
        $r_id=test_input($_COOKIE['reservation_id']);
      
        $query=mysqli_query($connection,"select seat_reserved_id from Seat_reserved where reservation_id=$r_id");
        
        if ( !$query ) 
        {
            throw new Exception($conn->error);
        }
        
      
        $size2=count($p_id);
        $i=0;
        
       while ($row = mysqli_fetch_array($query)) 
       {
           $p=$p_id[$i];
           $r_s=$row['seat_reserved_id'];
         
           $r=mysqli_query($connection,"call add_passenger_to_seat($r_s,$p);");
           
           if ( !$r )
           {
            throw new Exception($conn->error);
           }
           
           $i++;
           if($i==$size2)$i=0;
       }
       
   }catch(Exception $e)
    {
        header("location:error.php?");
    }
    
}
    header("location: summary.php");
    ob_flush();
    exit;
}
//if( !(empty($q['id_users'])) && $q['signature'] == $_COOKIE['signature']){
        $conn = mysqli_connect("149.156.136.151", "fwisniowski", "superhaslo","fwisniowski")or
    die("Connection failed: ");
        session_start();
        if(isset($_SESSION['group1']))
        {
            if(isset($_COOKIE['person_number']))
            {
                $person_number=test_input($_COOKIE['person_number']);
?>

<!DOCTYPE html>
<!--<div  id="Flightr" class="max_width_center container w3-card-4 w3-white" style="">-->
<script>
    showFlight(<?php echo $group1;?>,'doP');
    //showFlight(this.value,'zP')
</script>

 
<div  id="container2" class="container  w3-card-4  w3-white" style="min-height:1000px;padding-top:100px">
    <form method="post" name="pass" action="" data-toggle="validator">
        <div class="row " style=""> 
                <div id="dane" class="col-md-9" >
                <div class="tekst"><b>Wprowadź dane pasażera</b></div>
                <?php   
            $i=0;    
        ?>

                <?php
            while ($i++<$_COOKIE['person_number']){
                     
        ?>
                <div class="tekst"><?php echo $i?>: osoba</div>
                <div class="  w3-light-grey" style="padding:15px 15px 15px 15px;margin:0px 0 20px 0">
                   
                    <div class="row">
                        <div class="col-xs-3 form-group ">
                            <label for="ex1">TYTUŁ</label>
                                <select  class="form-control" id="sel1" name="p_title[]" required>
                                    <option disabled selected value> Wybierz </option>
                                    <option  value="1">Pan</option>
                                    <option  value="2">Pani</option>
                                </select>
                        </div>
                        <div class="col-xs-5 form-group has-feedback">
                            <label for="p_name[]">IMIĘ</label>
                            <input pattern"[a-zA-Z0-9]+" class="form-control" id="p_name[]" name="p_name[]" type="text" placeholder="Wprowadź imię/imiona pasażera" required>
                        </div>
                     </div>
                   
                    <div class="row">
                        <div class="col-xs-8 form-group ">
                            <label for="p_surname[]">NAZWISKO</label>
                            <input required="required" class="form-control" id="p_surname[]" name="p_surname[]" type="text" placeholder="Wprowadź nazwisko/nazwiska pasażera">
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-xs-8 form-group">
                            <div class="checkbox">
                                
                                <label>
                                    <input id="p_asysta[]" name="p_asysta[]" type="checkbox"  value="1">Pasażer wymaga specjalnej asysty</label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <?php };?>
                <div class="tekst">Wprowadź dane kontaktowe</div>
                 <div class="  w3-light-grey" style="padding:15px 15px 15px 15px;margin:0 0 10px 0">
                   
                    
                   
                    <div class="row">
                        <div class="col-xs-8 form-group">
                            <label for="p_email">E-MAIL</label>
                            <input required="required" class="form-control" id="p_email" type="email" name="p_email" placeholder="Wprowadź adres email">
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-xs-3 form-group">
                           
                        </div>
                        <div class="col-xs-5">
                            <label for="ex2">NUMER TELEFONU</label>
                            <input class="form-control" id="ex2" type="tel" name="telephone" placeholder="Wprowadź numer telefonu">
                        </div>
                     </div>
                    
                </div>
            </div>
         
            <div id="" class=" col-md-3" style="" >
                
                <div  id="right3" class="w3-card-2" >
                
                    <div id="caption" class="w3-blue caption_padding" style="padding: 8px 10px 8px 10px;">
                        Bilety lotnicze
                    </div>
                      
                    <div id="doP" style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;">
                        <div><?php //echo date( 'd.m.Y', $time ) ?></div>
                        <div><?php //echo date( 'H:i', $time ) ." ".$_COOKIE['DepartureCity'];  ?></div>
                        <div><?php  //echo date('H:i',$arrival_time)." ".$_COOKIE['ArrivalCity']; ?></div>
                    </div>
                    
                    <div id="zP" style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;display:none">
                    
                        <div><?php //echo date( 'd.m.Y', $time ) ?></div>
                        <div><?php // echo date('H:i',$arrival_time)." ".$_COOKIE['ArrivalCity']; ?></div>
                        <div><?php //echo date( 'H:i', $time ) ." ".$_COOKIE['DepartureCity'];  ?></div>
                    
                    </div>
                    
                    <div id="pas" style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;">
                   <span></span>
                        <div><?php echo "Liczba pasażerów: ". $person_number?></div>
                        <div></div>
                    </div>
                    
                    <div id="butN" style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;">
                        <div><?php if(isset($_COOKIE['price']))echo "Do zapłaty: ". $_COOKIE['price']." zł";?></div>
                        <button type="submit" class="w3-input w3-btn w3-blue" style="margin-top:30px" id ="next" name="next">Dalej</button>
                    </div>
        </div>
                 <!--
<div class="20p table-responsive" style="margin-top:50px;">
    
    <table class="#"  style="width:100%;background-color:white;margin-top:10px;margin-left:auto;margin-right:auto;padding: 0 2em;z-index:5;">
    <?php   
            $i=0;    
        ?>

                <?php
            while ($i++<$_COOKIE['person_number']){
                     
        ?>
          <tr style="height:60px;margin:10px 10px 10px 10px;">
            <td><input class="w3-input w3-border klikniecie" type="text" id="p_name[]" name="p_name[]" placeholder="name" ></td>
            <td><input  class="w3-input w3-border klikniecie" type="text" id="p_surname[]" name="p_surname[]" placeholder="surname" ></td>
            <tr>
              <td>
                <input list="city" class="w3-input w3-border klikniecie" type="text" id="p_city[]" name="p_city[]" placeholder="city" >
              
              </td>
                <td>
                <input list="number" class="w3-input w3-border klikniecie" type="telephone" id="p_number[]" name="p_number[]" placeholder="phone number" >
              
              </td>
            
              </tr>
          </tr>
    <?php };?>
    </table>
    </div>-->
<!--<div class="max_width_center" style="margin-top:50px;">
    

<button onclick="history.go(-1);">Wstecz</button>


   <button type="submit"  style="float:right;" name="next">Rezerwuj</button>
</div>
-->
<?php }?>

</div>
            
        
       </form>

     </div>
    </div>
    <script>
  

        function pass1(name,surname,title)
        {
            var elements= document.getElementsByName('p_name[]');
            elements[0].value=name;
            var elements= document.getElementsByName('p_surname[]');
            elements[0].value=surname;
            var elements= document.getElementsByName('p_title[]');
            elements[0].value=title;
        }
   
        function contact(email)
        {
            document.getElementById("p_email").value=email;
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
            if(!empty($idu))
            {
                $user_info=mysqli_fetch_assoc(mysqli_query($conn,"select person_id from User2 where user_id='{$idu}';"));
                $user_info=$user_info['person_id'];
          
                $person=mysqli_query($connection,"select n.namee as name, s.surname, title from Passenger p,Namee n,Surname s where p.name=n.name_id and p.surname=s.surname_id and person_id='{$user_info}';");
                    $row=mysqli_fetch_assoc($person);
        
                echo '<script>pass1("'.$row["name"].'","'.$row["surname"].'","'.$row["title"].'");</script>';
       
                echo '<script>contact("'.$email.'");</script>';
            }
            
            if(isset($_SESSION['group2']))
            {
        
                echo '<script> document.getElementById("zP").style.display="block";</script>';
                echo '<script> showFlight('.$group2.',"zP");</script>';
            }
           
        }
        else
        {
            
            abort();
        }
		//echo "Zalogowany użytkownik o ID: " . $q['id_users'] ;
	//}else{
   //     echo $q['signature'] . $_COOKIE['signature'];
	//	header("location:login.php");
		//exit;
  //  }

function abort()
{
    unset_cookie_except_session();
    header ("location: error.php?idu=0");
}
?>
<?php ob_flush();?> 