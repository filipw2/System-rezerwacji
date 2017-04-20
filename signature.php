<?php

$q=0;

if(isset($_COOKIE['id'])&& $_COOKIE['id']!='0')
{
	$q=mysqli_fetch_assoc(mysqli_query($connection,
                                       "select id_users, signature from sesja where id= '$_COOKIE[id]' and 
                                       ip= '$_SERVER[REMOTE_ADDR]' and web='$_SERVER[HTTP_USER_AGENT]';"));
    
    if(!empty($q['id_users']) && $q['signature']==$_COOKIE['signature'])
    {
	    $signature= md5(rand(-10000,10000). microtime()). md5(crc32(microtime()). $_SERVER['REMOTE_ADDR']);
        $idu=$q['id_users'];
    
        mysqli_query($connection,"update sesja set signature='$signature' where id_users='$idu';");
        if(! mysqli_errno($connection))
            setcookie("signature",$signature);
    }
    else
    {
		header('Location: logout.php');
		
    }
}
?>