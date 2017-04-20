<?php
include("base.php");
require_once('signature.php');

if(! isset($_COOKIE['id']))
{
    header("location:login.php");
    exit;
}

//echo $q['id_users'] ." \n". $q['signature']." \n".$_COOKIE['signature'];
	if(isset($q['id_users'])&& $q['signature']==$_COOKIE['signature'])
    {
?>

<!DOCTYPE html>

<div  id="container2" class="container w3-card-4  w3-white profil" style="min-height:1000px;padding-top:100px;">
    <div style="border-bottom: 3px solid #ddd;margin: 20px 0 30px 0">Twój profil</div>
        <div class="row" style=""> 
              <p> Podany adres e-mail oprócz logowania służy także naszym konsultantom do kontaktu z Tobą.</p>
            <div class="col-md-12" style="margin:0 130px 0 130px">
             
                <div class="col-xs-4">
                E-mail
                </div>
                <div class="col-xs-8">
                <?php echo $r['email'];?>
                </div>
                <div class="col-xs-4">
                Hasło
                </div>
                <div class="col-xs-8">
                <a href="password.php">Zmiana hasła</a>
                </div>
            </div>   
        </div>
    <div style="border-bottom: 3px solid #ddd;margin: 20px 0 30px 0">Twój dane</div>
        <div class="row" style=""> 
              <p> Podany adres e-mail oprócz logowania służy także naszym konsultantom do kontaktu z Tobą.</p>
            <div class="col-md-12" style="margin:0 130px 0 130px">
             <div class="col-xs-4">
                Dane osobowe
                </div>
                <div class="col-xs-8">
                <?php
        if($r['person_id']==null)
        {
                ?>
                
                    <a href="dane.php">Dodaj dane</a>
                
                <?php 
        }
        else
        {
            $p_id=$r['person_id'];
            $person=mysqli_query($connection,"select n.namee as name, s.surname, title from Passenger p,Namee n,Surname s where p.name=n.name_id and p.surname=s.surname_id and person_id='{$p_id}';");
            $row=mysqli_fetch_assoc($person);
                 ?>
                    <div><a href="dane.php" >Zmień dane</a></div>
                    <div class="row">
                    <div class="col-xs-4" style="padding-left:0;">
                        Tytuł
                        
                    </div>
                    <div class="col-xs-8">
                        <?php
                            if($row['title']==1){
                                echo "Pan";
                            }else{
                                echo "Pani";
                            }
                        ?>
                    </div>
                    </div>
                     <div class="row">
                    <div class="col-xs-4" style="padding-left:0;">
                        Imię
                    </div>
                    <div class="col-xs-8">
                        <?php
                           echo $row['name'];
                        ?>
                    </div>
                    </div>
                     <div class="row">
                     <div class="col-xs-4" style="padding-left:0;">
                        Nazwisko
                    </div>
                    <div class="col-xs-8">
                        <?php
                           echo $row['surname'];
                        ?>
                    </div>
                    </div>
                <?php } ?>
                </div>
            </div>   
        </div>
    <div class="row"> 

            
            
        </div>
</div>









<!-- Footer -->
<footer class="w3-container w3-center w3-opacity w3-margin-bottom">
  <h5>Find Us On</h5>
  <div class="w3-xlarge w3-padding-16">
    <i class="fa fa-facebook-official w3-hover-text-indigo"></i>
    <i class="fa fa-instagram w3-hover-text-purple"></i>
    <i class="fa fa-snapchat w3-hover-text-yellow"></i>
    <i class="fa fa-pinterest-p w3-hover-text-red"></i>
    <i class="fa fa-twitter w3-hover-text-light-blue"></i>
    <i class="fa fa-linkedin w3-hover-text-indigo"></i>
  </div>
</footer>

<script>
// Tabs
function openLink(evt, linkName) 
    {
        var i, x, tablinks;
        x = document.getElementsByClassName("myLink");
   
        for (i = 0; i < x.length; i++) 
        {
            x[i].style.display = "none";
        }
  
        tablinks = document.getElementsByClassName("tablink");
 
        for (i = 0; i < x.length; i++) 
        {
            tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
        }
 
        document.getElementById(linkName).style.display = "block";
 
        evt.currentTarget.className += " w3-red";
    }
// Click on the first tablink on load
//document.getElementsByClassName("tablink")[0].click();
</script>

</body>
</html>
		<?php
		echo "Zalogowany użytkownik o ID: " . $q['id_users'] ;
	}else{
        
		header("location:login.php");
		exit;
        ob_flush();
    }
?>

