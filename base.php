
<?php 

header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

ob_start(); 

$connection = mysqli_connect("127.0.0.1", "root", "","fwisniowski")or
    die("Connection failed: ");

mysqli_set_charset($connection,"utf8");
	
function get_id()
{
    global $connection;
        $id=test_input($_COOKIE['id']);
	$q=mysqli_fetch_assoc(mysqli_query($connection,
"select id_users, signature from sesja where id= '$id' and 
ip= '$_SERVER[REMOTE_ADDR]' and web='$_SERVER[HTTP_USER_AGENT]';"));

if(!empty($q['id_users']) && $q['signature']==$_COOKIE['signature']){
	
    $idu=$q['id_users'];
	
	
    return $q['id_users'];
	}else{
		return 0;
}

	}
	
function unset_cookie_except_session()
{
    foreach($_COOKIE as $key => $value)
    {
        if($key != 'id' && $key != 'signature' && $key != 'cookies_accepted')
        {
            setcookie("$key",0,time()-1);
        }
    }
}



function check_user(){
	global $connection;// = mysqli_connect("149.156.136.151", "fwisniowski", "superhaslo","fwisniowski")or
    //die("Connection failed: ");
	$id=test_input($_COOKIE['id']);
	$q=mysqli_fetch_assoc(mysqli_query($connection,
"select id_users, signature from sesja where id= '$id' and 
ip= '$_SERVER[REMOTE_ADDR]' and web='$_SERVER[HTTP_USER_AGENT]';"));
$user_id=$q['id_users'];
if(!empty($q['id_users'])){
	
		return true;
	}else{
		return false;
}
}

function test_input($data) 
{
    
    $data = trim($data);
    $data = stripslashes($data);
    $data= htmlentities(str_replace(array("'", "\""), "",htmlspecialchars($data)));
  //$data = htmlspecialchars($data, ENT_DISALLOWED);
    return $data;
}
	?>
<!DOCTYPE html>
<html>
<head>
<title>PAIrways</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://files.codepedia.info/uploads/iScripts/html2canvas.js"></script>
    <script type="text/javascript" src="js/cookie.js"></script>


<noscript>JavaScript is off. Please enable to view full site.</noscript>
</head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link id="themecss" rel="stylesheet" type="text/css" href="//www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<link rel="stylesheet" href="temp.css">
    <link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
<script src="//code.jquery.com/jquery-1.10.2.js"></script>  
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
    <script src="js/bootstrap.js"></script> 
<link rel="stylesheet" href="datepicker/css/datepicker.css">  
<style>
.ui-datepicker {
   border: 1px solid #555;
   color: #EEE;
 }
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
.myLink {display: none}
fieldset {
  border: none;
    padding: 0;
}

    .profil div{
    margin: 2px 0px 2px 0px;
    }
    
.some-class {
  float: left;
  border:solid red 0;
  margin: 5px 10px 5px 0px;
}

label {
  float: left;
  clear: none;
  display: block;
  padding: 2px 1em 0 0;
  margin-left:5px;
}
.najechanie:hover{
	border:1px solid red;
}
.klikniecie:focus{
	background-color:007FFF;
    border:1px solid red;
}
input[type=radio],
input.radio {
  float: left;
  clear: none;
  margin: 10px 0 0 10px;
  width:auto;
}
    table th,td{width:20%;}
    #container {
    width:100%;
    
}
    #container > div
{
    display: inline-block;
    
}
    #left{float:left;width:100px;}
#right{float:right;width:100px;}
    .affix{
        width:15%;
        position:fixed;
    }
    
    @media (max-width: 854px) {
    .affix {
        width:auto!important;
        position: fixed;
        
    }
        #dane{margin-top:0px;}
        
}
    .m{
    margin-top:54px;
    }
    .f{
        position:fixed;
        height:54px;
    }
    @media (max-width: 600px) {
        .f {
        position:relative;
            height:216px;
        }
        .m {
        margin-top:0px;
        }
    }
</style>

<body class="w3-light-blue" style="min-height:200%;">

<!-- Navigation Bar -->

<ul class="w3-navbar f w3-card-2 w3-white w3-border-bottom w3-xlarge" style="top:0px;width:100%;z-index:80;">
    <div style="max-width:1170px;margin-left:auto;margin-right:auto;">
  <li><a href="index.php" class="w3-text-blue w3-hover-blue">
    <!--  <b><i class="fa fa-map-marker w3-margin-right"></i>Logo</b>
      -->
      <img src="human_cannonball.jpg" style="padding:0px;margin:0px;" class="fa fa-map-marker w3-margin-right" width="74" height="38" >
      </a></li>
     <!--  <li class="w3-left"><a href="index.php" class="w3-hover-blue w3-text-grey"><i class="fa fa-margin-left"></i>Rezerwuj lot</a></li>-->
        <li class="w3-left"><a href="reservation.php" class="w3-hover-blue w3-text-grey"><i class="fa fa-margin-left"></i>Moja rezerwacja</a></li>
    <?php
  if(isset($_COOKIE['id']) && check_user()){
	  $a=get_id();
  $query = mysqli_query($connection,"select * from User2 where user_id='$a';");
		$r=mysqli_fetch_assoc($query);
        $email=$r['email'];
        ?>
  <li class="w3-right"><a href="logout.php" class="w3-hover-blue w3-text-grey"><i class="fa fa-margin-left"></i>Wyloguj</a></li>
  <li class="w3-right"><a href="profile.php" class="w3-hover-blue w3-text-grey"><i class="fa fa-margin-left"></i><?php echo $email;?></a></li>
  
  <?php } else {?>
  <li class="w3-right"><a href="login.php" class="w3-hover-blue w3-text-grey"><i class="fa fa-margin-left"></i>Logowanie</a></li>
  <li class="w3-right"><a href="register.php" class="w3-hover-blue w3-text-grey"><i class="fa fa-margin-left"></i>Rejestracja</a></li>
  <?php }?> 
 <!-- <li class="w3-right"><a href="#" class="w3-hover-blue w3-text-grey"><i class="fa fa-search"></i></a></li>-->
    </div>
</ul>
<script>
    
    
    function showFlight(str,div) 
    {
        if (str == "") 
        {
            document.getElementById(div).innerHTML = "";
            return;
        } 
        else 
        {
            if (window.XMLHttpRequest) 
            {
            // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } 
            else 
            {
            // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200) 
                {
                    document.getElementById(div).innerHTML = this.responseText;
                }
            };
            
            xmlhttp.open("GET","getinfo.php?q="+str,true);
            xmlhttp.send();
        }
    }
    var price1=0;
    var price2=0;
  
    var price=0;
</script>
  
