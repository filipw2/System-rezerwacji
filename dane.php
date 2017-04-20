<?php
include('base.php');
require_once('signature.php');

if(! isset($_COOKIE['id']))
{
    header("location:login.php");exit;
}

	if(!empty($q['id_users'])&& $q['signature']==$_COOKIE['signature'])
    {


        if ($_SERVER['REQUEST_METHOD']== "POST")
        {
            
            if(empty($_POST['p_name']) || empty($_POST['p_surname']) || empty($_POST['p_title']))
            {
                
            }
            else
            {
                
                try
                {
                    
                    $connection->autocommit(false);
                    
                    $p_name=htmlspecialchars(addslashes ($_POST['p_name']));
                    $p_surname=htmlspecialchars(addslashes ($_POST['p_surname']));
                    $p_title=test_input($_POST['p_title']);
                   
                    $result=mysqli_query($connection,"call addPassenger('".$p_name."','".$p_surname."','0','".$p_title."',@p_id);");
    
                    if($result == false)
                        throw new Exception($conn->error);
                    
                    $row=mysqli_fetch_assoc(mysqli_query($connection,"select @p_id;"));
                    
                    if( empty($row['@p_id']) || $row['@p_id']==null)
                        throw new Exception("blad przy dodawaniu danych");
                    
                    $id=$row['@p_id'];
             
            
                    $update=mysqli_query($connection,"update User2 set person_id='{$id}' where user_id='{$idu}';");
           
                    if($update == false)
                        throw new Exception($conn->error);
            
                    $connection->commit();
                    $connection->autocommit(true);
           
                    header("location: profile.php");
                    
                }
                catch(MySQLException $e)
                {
                    $connection->rollback();
                    $connection->autocommit(true);
            
                }
            }
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
<div  id="container2" class="container w3-card-4  w3-white profil" style="min-height:1000px;padding-top:100px;">
    <div style="border-bottom: 3px solid #ddd;margin: 20px 0 30px 0">Zmień dane</div>
        <form method="post">
                <div class="" style="padding:15px 15px 15px 15px;margin:10px 0 10px 0">
                   
                    <div class="row">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-6  form-group">
                            <label for="ex1">TYTUŁ</label>
                                <select class="form-control" id="sel1" name="p_title">
                                    <option disabled selected value> Wybierz </option>
                                    <option  value="1">Pan</option>
                                    <option  value="2">Pani</option>
                                </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-6">
                            <label for="p_name">IMIĘ</label>
                            <input class="form-control" id="p_name" name="p_name" type="text" placeholder="Wprowadź imię/imiona pasażera">
                        </div>
                     </div>
                   
                    <div class="row">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-6 form-group">
                            <label for="p_surname">NAZWISKO</label>
                            <input class="form-control" id="p_surname" name="p_surname" type="text" placeholder="Wprowadź nazwisko/nazwiska pasażera">
                        </div>
                        
                    </div>
                     <div class="row">
                         <div class="col-xs-3"></div>
                    <div class="col-xs-6 form form-group" style="margin-top:10px;">
                            <input class="button" name="submit" type="submit" value=" Zatwierdź ">
                        </div>
                    </div>
                </div>
        </form>
</div>


</body>
</html>
		<?php
	
        echo "Zalogowany użytkownik o ID: " . $q['id_users'] ;
	}
    else
    {
        
		header("location:login.php");
		exit;
        
    }
?>
<?php ob_flush();?> 
