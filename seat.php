<?php
//include('base.php');
require_once('signature.php');

function getCheck($array)
{
    $number=0;
    
    foreach($array as $value)
        if(isset($value))
            $number=$value;
    
    return $number;
}
function test_input($data) 
{
    
  $data = trim($data);
  $data = stripslashes($data);
$data= htmlspecialchars(str_replace(array("'", "\""), "",htmlspecialchars($data)));
  //$data = htmlspecialchars($data, ENT_DISALLOWED);
  return $data;
}

if ($_SERVER['REQUEST_METHOD']== "POST") 
{
    if(isset($_POST['group1']) && (isset($_POST['group2']) || $_COOKIE['x']=='z'))
    {
        
        session_start();
        
        $msg=0;
        $get=0;
        
        $group1=test_input(getCheck($_POST['group1']));
        
        $_SESSION['group1']=$group1;
        setcookie('group1',$group1);
        
        $get="group1=".$group1;
        
        if(isset($_POST['group2']))
        {
            $group2=test_input(getCheck($_POST['group2']));
            $_SESSION['group2']=$group2;
            setcookie('group2',$group2);
            $get=$get."&group2=".$group2;
        }
  
        //if(! isset($_COOKIE['id'])){
    
        // header("location:login.php");
        //                        exit;
       // }

	//if( !(empty($q['id_users'])) && $q['signature'] == $_COOKIE['signature']){
        
        $conn = mysqli_connect("149.156.136.151", "fwisniowski", "superhaslo","fwisniowski") or
            die("Connection failed: ");
       
        if(isset($_SESSION['group1']))
        {
            if(isset($_COOKIE['person_number']))
            {
                $person_number=test_input($_COOKIE['person_number']);
                $group1=$_SESSION['group1'];
   
                if(!empty($idu))
                {     
                    $user_info=mysqli_fetch_assoc(mysqli_query($conn,"select person_id from User2 where user_id='{$idu}';"));
                    $user_info=$user_info['person_id'];
                }

                try 
                {

   // $conn->
                    $conn->autocommit(FALSE);
					
					mysqli_query($conn,"begin;");
                     // i.e., start transaction
                   // $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
                    
                    
                    $id=test_input($q['id_users']);
    
                    if(!isset($_COOKIE['reservation_id']))
                    {
      
                        $query = "INSERT INTO Reservation (is_confirmed)  VALUES (0);";
                        $result= $conn->query($query);
                        $reservation_id=mysqli_insert_id($conn);
                        setcookie('reservation_id',$reservation_id);
    
                        if ( !$result ) 
                        {
                            throw new Exception($conn->error);
                        }
                    }
   
                    if(!empty($_COOKIE['reservation_id']))
                        $reservation_id=test_input($_COOKIE['reservation_id']);
   
                    $flight_class=test_input($_COOKIE['flight_class']);
                    $q=mysqli_fetch_assoc(mysqli_query($conn,"select plane_number from Flight where flight_number={$group1};"));
   
                    if ( !$q ) 
                    {
                        throw new Exception($conn->error);
                    }
                   // mysqli_query($conn,"begin transaction;");
                
                    
                    $pn=$q['plane_number'];
                    $i=0;
                    $id_array=array();
    
                    while($i< $person_number)
                    {
        
                        $query2=mysqli_query($conn,"call seat($pn,$flight_class,$group1,$reservation_id,@r);");
                       
                        $query2=mysqli_query($conn,"select @r;");
                       
                        $row=mysqli_fetch_assoc($query2);
                        
                        if( empty($row['@r']) || $row['@r']==0)
                        {
                            $msg="brak1=1";
                            throw new Exception("brak miejsc 1");
                        }
                        $id_array[$i]=$row['@r'];
                        
                        $i++;
                    }
                    $conn->commit();
                    $conn->autocommit(TRUE);
                }
                catch ( Exception $e ) 
                {

                   // echo $conn->error;
                  //  echo $e->getMessage();
                    $conn->rollback(); 
                  //  mysqli_query($conn,'rollback;');
                    
     
                    header ("location: result.php?".$msg);
                    exit;
                    // abort();
                }
                
                
                $conn->autocommit(false);
                
                try
                {
    
   // setcookie('id[]',$id_array);
/*$query2=mysqli_query($conn,"select seat_id from Seat s where s.aircraft_id={$q['plane_number']} and s.class_id={$flight_class} and seat_id not in (select seat_id from Seat_reserved Sr where Sr.flight_id={$group1});");
    if ( !$query2 ) {
        //$result->free();
        
        throw new Exception($conn->error);
    }
     sleep(10);
    $i=0;
    if($query2->num_rows<$person_number)throw new Exception("brak miejsc");
    while($i< $person_number){
    $r2=mysqli_fetch_assoc($query2);
    $seat=$r2['seat_id'];
    
    $r3=mysqli_query($conn,"insert into Seat_reserved(seat_id,reservation_id,flight_id) values('$seat','$reservation_id','$group1');");
        $i++;
    }
    if ( !$r3 ) {
        //$result->free();
        throw new Exception($conn->error);
    }
   */
   
                    
               
                    if(isset($_SESSION['group2']))
                    {
                        $group2=$_SESSION['group2'];
                        $flight_class=test_input($_COOKIE['flight_class']);
                        $q=mysqli_fetch_assoc(mysqli_query($conn,"select plane_number from Flight where flight_number={$group2};"));
   
                        if ( !$q ) 
                        {
                            throw new Exception($conn->error);
                        }
                   
                        $pn=$q['plane_number'];
                        
                        $i=0;
                        $id_array2=array();
    
                        while($i< $person_number)
                        {
         
                            $query2=mysqli_query($conn,"call seat($pn,$flight_class,$group2,$reservation_id,@r);");
                            $query2=mysqli_query($conn,"select @r;");
                            $row=mysqli_fetch_assoc($query2);
                            
                            if( empty($row['@r']) || $row['@r']==0)
                            {
                                $msg="brak2=1";
                                throw new Exception("brak miejsc lot 2");
        
                            }
                            
                            $id_array2[$i]=$row['@r'];
                            $i++;
                        }
                   
                    }
  
                    $conn->commit();
   
                    unset($_POST);
                    $conn->autocommit(TRUE);
    
                }
                catch ( Exception $e ) 
                {

                   // echo $conn->error;
                  //  echo $e->getMessage();
                    $conn->rollback(); 
                    mysqli_query($conn,'rollback;');
                    
     
                    header ("location: result.php?".$msg);
                    exit;
                    // abort();
                }
            }
        }//}
    
    header ("location: passanger.php?".$get);
    ob_flush();
    exit;
    
    }
    
}
else
{
    header("location: result.php");
}

?>