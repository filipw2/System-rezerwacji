
<?php
unset($_POST);
$conn = mysqli_connect("149.156.136.151", "fwisniowski", "superhaslo","fwisniowski")or
    die("Connection failed: ");
$q = mysqli_query($conn, "delete from sesja where 
id = '$_COOKIE[id]' and web = '$_SERVER[HTTP_USER_AGENT]';");	
mysqli_query($conn,"call clear();");
foreach($_COOKIE as $key => $value){
       if($key != 'cookies_accepted')
            setcookie("$key",0,time()-3600);
        
    }

header("location:index.php");

?>