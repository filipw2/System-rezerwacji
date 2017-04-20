<?php
include('base.php');
include('signature.php');
session_start();
session_unset();
if(!empty($_COOKIE['reservation_id']) && isset($_COOKIE['reservation_id']))
{
    $r_id=$_COOKIE['reservation_id'];

    try
    {
        $result=mysqli_query($connection,"update Reservation set is_confirmed='1' where reservation_id='{$r_id}';");
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        unset_cookie_except_session();
        header('Location: summary.php');
        exit;
    }
    
    ?>
    
 <div  id="container2" class="container w3-card-4  w3-white profil" style="min-height:1000px;padding-top:100px;">
    <div style="border-bottom: 3px solid #ddd;margin: 20px 0 30px 0">Podsumowanie</div>
        <div class="row" style=""> 
            
            <div class="col-md-12" style="margin:0 130px 0 130px">
             <div class="row">
                <div class="col-xs-12">
                  <h2> Rezerwacja przebiegła pomyślnie!</h2> 
                </div>
                
                 </div>
                <div class="col-xs-12">
                    <h3>Twój numer rezerwacji to: <b><?php echo "  ".$r_id;?></b></h3>
                
                   
                </div>
                <div class="col-xs-12" style="margin-top:50px;">
                    Informacje dotyczące płatności zostaną wysłane na podany adres email.
                
                </div>
            </div>   
        </div>
</div>
<div  id="container2" class="container w3-card-4  w3-white profil" style="min-height:1000px;padding-top:100px;">
    <div>
        <span class="col-centered">Rezerwacja przebiegła pomyślnie</span>
    </div>
    <div>
        <span class="col-centered">Twój numer rezerwacji to: <?php echo $r_id;?></span>
    </div>
    
</div>

</body>
</html>   
    
   <?php 
}
else
    header("location:index.php");

?>

<?php ob_flush();?> 