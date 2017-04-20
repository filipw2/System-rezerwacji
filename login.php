

<?php
include("base.php");
//session_start(); // Starting Session
$error=''; // Variable To Store Error Message
?>
<!DOCTYPE html>

<style>


@media print{
	form{
		display:none;
	}
}
   
.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
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
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
</style>


<div class="login-page">
  <div class="form" >
    <form class="login-form" action="" method="post">
        <h2 style="margin-top:0;margin-bottom:20px;">Logowanie</h2>
        <input id="email" name="email" placeholder="email" type="email">
        <input id="password" name="password" placeholder="password" type="password">
        <input class="button" name="submit" type="submit" value=" Login ">
        <p id="errorDiv" class="message" style="display:none;"></p>
        <p class="message">Nie masz konta? <a href="register.php">Zarejestruj</a></p>
    </form>
  </div>
</div>
    <script>
  $('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
        
        
        
    </script>
</body>
</html>



<?php
if (isset($_POST['submit'])) 
{
    if (empty($_POST['email']) || empty($_POST['password'])) 
    {
        $error = "Username or Password is invalid 1";
    }
    else
    {
   

        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $email=test_input($_POST['email']);
 
            $connection = mysqli_connect("127.0.0.1", "root", "","fwisniowski")or
                die("Connection failed: ");

    //$email = stripslashes($email);
    //$password = stripslashes($password);
    //$email = mysqli_real_escape_string($email);
    //$password = mysqli_real_escape_string($password);
            $qsol = mysqli_query($connection, "select sol from User2 where email='$email'");

            $sol1= mysqli_fetch_assoc ($qsol);
            $sol=$sol1['sol'];
    //echo $sol;

   
            $password=sha1($_POST['password'] .$sol);
  
            $query = mysqli_query($connection,"select count(*) cnt,user_id from User2 where password='$password' AND email='$email'");

            $query= mysqli_fetch_assoc ($query);
  
            if($query['cnt'])
            {
                $id= md5(rand(-10000,10000). microtime()). md5(crc32(microtime()). $_SERVER['REMOTE_ADDR']);
                $signature = md5(rand(-10000,10000). microtime()). md5(crc32(microtime()). $_SERVER['REMOTE_ADDR']);
                mysqli_query($connection,"delete from sesja where id_users = '$query[user_id]';");
                mysqli_query($connection,"insert into sesja (id_users,id,signature,ip,web) values
                    ('$query[user_id]','$id','$signature','$_SERVER[REMOTE_ADDR]','$_SERVER[HTTP_USER_AGENT]');");
             
                if(! mysqli_errno($connection))
                {
                    setcookie("id",$id);
                    setcookie("signature",$signature);

                    
                    header("location: index.php");
                    ob_flush();

                }
                else
                {
                    echo "<script>showError('blad podczas logowania','errorDiv');</script>";
                }
            }
            else
            {
                echo "<script>showError('Hasło lub email niepoprawne','errorDiv');</script>";
            }
        }

    }
}

?>


<?php ob_flush();?> 