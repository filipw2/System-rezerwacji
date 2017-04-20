<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysqli_connect("127.0.0.1", "root", "","fwisniowski")or
    die("Connection failed: ");
	
if(! isset($_COOKIE['id'])){header("location:login.php");exit;}
$q=mysqli_fetch_assoc()mysqli_query($connection,"
	select id_users from sesja where
	id= '$_COOKIE[id]' and ip= '$_SERVER[REMOTE_ADDR]'and web='$_SERVER[HTTP_USER_AGENT]');"));
	if(!empty($q['id_users'])){}else{header("location:login.php");exit;}
?>