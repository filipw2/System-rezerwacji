<?php
include('base.php');
require_once('signature.php');

if(! isset($_COOKIE['id']))
{
    header("location:login.php");
    exit;
}
?>

        
        <!DOCTYPE html>
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
</style>
<script>
    function showError(msg,el)
        {
            document.getElementById(el).style.display="block";
            document.getElementById(el).innerHTML=msg;
        }
</script>
<div  id="container2" class="container w3-card-4  w3-white profil" style="min-height:1000px;padding-top:100px;">
    <div style="border-bottom: 3px solid #ddd;margin: 20px 0 30px 0">Zmień hasło</div>
        <form method="post">
                <div class="" style="padding:15px 15px 15px 15px;margin:10px 0 10px 0">
                   
                    <div class="row">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-6">
                            <label for="oldpass">OBECNE HASŁO</label>
                            <input class="form-control" id="oldpass" name="oldpass" type="password" placeholder="Wprowadź obecne hasło">
                        </div>
                     </div>
                    <div class="row">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-6">
                            <label for="newpass">HASŁO</label>
                            <input class="form-control" id="newpass" name="newpass" type="password" placeholder="Wprowadź nowe hasło">
                        </div>
                     </div>
                   
                    <div class="row">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-6 form-group">
                            <label for="newpass2">POWTÓRZ HASŁO</label>
                            <input class="form-control" id="newpass2" name="newpass2" type="password" placeholder="Powtórz nowe hasło">
                        </div>
                        
                    </div>
                     <div class="row">
                         <div class="col-xs-3"></div>
                    <div class="col-xs-6 form form-group" style="margin-top:10px;">
                            <input class="button" name="submit" type="submit" value=" Zatwierdź ">
                        </div>
                         
                        </div>
                     <div class="row">
                         <div class="col-xs-3"></div>
                         <div class="col-xs-6 form form-group" style="margin-top:10px;">    
                         <p id="errorDiv" class="message" style="display:none;margin-left:auto"></p>
                         </div>
                    </div>
                
</form>
</div>


</body>
</html>

<?php
if(!empty($q['id_users'])&& $q['signature']==$_COOKIE['signature'])
{
    if ($_SERVER['REQUEST_METHOD']== "POST")
    {       
        $error='';
        
        if (isset($_POST['submit'])) 
        {
            if (empty($_POST['oldpass']) || empty($_POST['newpass']) || empty($_POST['newpass2'])){
                $error = " Password is invalid";
            }
            else
            {       
                $password=$_POST['oldpass'];
                $qsol = mysqli_query($connection, "select sol from User2 where user_id='$idu'");

                $sol1= mysqli_fetch_assoc ($qsol);
                $sol=$sol1['sol'];

                $password=$password.$sol;
                $password=sha1($password);


                $query = mysqli_query($connection,"select count(*) cnt from User2 where password='{$password}' AND user_id='{$idu}'");
                $query= mysqli_fetch_assoc ($query);
   
                if($query['cnt'])
                {
                    $password=$_POST['newpass'];
                    $cpassword=$_POST['newpass2'];
                    if($cpassword==$password)
                    {
                        $sol = rand(-100000000,100000000);
                        $password=$password.$sol;
                        $password=sha1($password);
	   		
                        if ( mysqli_query($connection,"update User2 set password='{$password}', sol='{$sol}' where user_id='{$idu}';")===true)
                        {
                            header('Location: login.php');
                        } 
                        else 
                        {
                            echo "Error: <br>". $connection->error;
                        }
                    }
                    else 
                        echo "<script>showError('Hasła nie są takie same','errorDiv');</script>";
      
                }
                else
                {
                    echo "<script>showError('Błędne hasło','errorDiv');</script>";
    
                }
            }
        }
    }
?>

		<?php

}
else
{  
    header("location:login.php");
    exit;
}
?>
<?php ob_flush(); ?> 