<?php
include("base.php");
$error=''; // Variable To Store Error Message
?>
<script>
    function showError(msg,el)
        {
            document.getElementById(el).style.display="block";
            document.getElementById(el).innerHTML=msg;
        }
</script>

<!DOCTYPE html>


    <style>
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
    <!--
<form action="" method="post">
<input id="email" name="email" placeholder="email" type="text">

<input id="password" name="password" placeholder="password" type="password" onBlur="sprawdz()">
<input id="confirm_password" name="confirm_password" placeholder="confirm_password" type="password" onBlur="sprawdz();sprawdzCzyTakieSame();">
<input name="submit" type="submit" value=" Register " >
	
	
	
<span><?php echo $error; ?></span>
</form>-->
   
    <div class="login-page">
        <div class="form" >
            <form class="login-form" action="" method="post">
                <h2 style="margin-top:0;margin-bottom:20px;">Rejestracja</h2>
                <input id="email" name="email" placeholder="email" type="email">
      
                <input id="password" name="password" placeholder="password" type="password" onBlur="">
                <input id="confirm_password" name="confirm_password" placeholder="confirm_password" type="password" onBlur="">
                <input class="button" name="submit" type="submit" value=" Register ">
                <p id="errorDiv" class="message" style="display:none;"></p>
                <p class="message">Masz już konto?  <a href="login.php">Zaloguj</a></p>
            </form>
        </div>
    </div>
    <script>
  $('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
    </script>
</div>
</div>
<div id="inf" style="background-color:rgba(0,255,255,0.5) ;width:400px;height:110px;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);visibility:hidden;z-index:501;">
<div name="info" id="info"></div>
<div name="info2" id="info2"></div>
<input name="submit" type="button" value="hide" onClick="document.getElementById('inf').style.visibility='hidden'">
</div>

<?php
if (isset($_POST['submit'])) 
{
    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) 
    {
        $error = "Username or Password is invalid";
    }
    else
    {
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $email=test_input($_POST['email']);

            $password=htmlentities($_POST['password'],ENT_SUBSTITUTE);
            $cpassword=htmlentities($_POST['confirm_password'],ENT_SUBSTITUTE);
        }
        

        $connection = mysqli_connect("127.0.0.1", "root", "","fwisniowski")or
            die("Connection failed: ");

        //$email = stripslashes($email);
        //$password = stripslashes($password);
        //$cpassword = stripslashes($cpassword);
        //$email = mysql_real_escape_string($email);
        //$password = mysql_real_escape_string($password);


        $query = mysqli_query($connection,"select * from User2 where email='$email'");
        $rows = mysqli_num_rows($query);


        if ($rows == 0) 
        {
            if(sha1($_POST['password'])==sha1($_POST['confirm_password']))
            {
                $sol = rand(-100000000,100000000);
                //$password=$password.$sol;
                $password=sha1($_POST['password'].$sol);
                    $sql = "INSERT INTO User2 (email, password, sol) VALUES ('$email', '$password' , '$sol')";

                if ( mysqli_query($connection,$sql)===true) 
                {
                    //echo "New record created successfully";
                    header('Location: login.php');
                } 
                else 
                {
                    echo "Error: " . $sql . "<br>". $connection->error;
                }
            }
            else 
                echo "<script>showError('Hasła nie są takie same','errorDiv');</script>";
        }
        else
        {
            echo "<script>showError('Email jest już używany','errorDiv');</script>";
        }
        mysqli_close($connection); 
    }
}

?>

<script>

function sprawdz()
{
var tekst = document.getElementById('password').value;
	if(tekst.length<3 && tekst.length>0)
    {
		//alert("Za malo znakow");
		document.getElementById("info").innerHTML="Za malo zankow";
		document.getElementById("inf").style.visibility='visible';
		//setTimeout("document.getElementById('password').focus()",0);
	}
	else
		document.getElementById("info").innerHTML="";
}

function sprawdzCzyTakieSame()
{
	if(document.getElementById('password').value != document.getElementById('confirm_password').value){
		//alert("Hasla nie sa jednakowe");
		document.getElementById("info2").innerHTML="Hasla nie sa jednakowe";
		document.getElementById("inf").style.visibility='visible';
		//setTimeout("document.getElementById('password').focus()",0);
	}
	else
		document.getElementById("info2").innerHTML="";
}



</script>

</body>
</html>