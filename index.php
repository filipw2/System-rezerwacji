<?php
include('base.php');
require_once('signature.php');

#if(isset($_SESSION['login_user'])){
#header("location: profile.php");
#}
//<link href="style2.css" rel="stylesheet" type="text/css">
   // if(isset($_COOKIE['group1']))
  /*  if(isset($_COOKIE['reservation_id'])){
        $r_id=$_COOKIE['reservation_id'];
        try{
    $result=mysqli_query($connection,"delete from Reservation  where is_confirmed is null and reservation_id='{$r_id}' and user_id= '{$idu}';");
}catch(Exception $e){
   // echo $e->getMessage();
}
       // header("Refresh:0");
    }
*/
	$query = mysqli_query($connection,"select City_name from City");
$city=array();
$i=0;
while ($row = mysqli_fetch_array ($query)){
    $city[$i++]= $row ['City_name'];
}
    if ($_SERVER['REQUEST_METHOD']== "POST") 
    {
      
        foreach($_POST as $key => $field) 
        {
           
   
            $field = test_input($field);
 
            setcookie($key,$field);
        }
      
        if(!empty($_POST['DepartureCity']) && !empty($_POST['ArrivalCity']) && !empty($_POST['date']))
            if(($_POST['x']=='y' && !empty($_POST['date2'])) ||$_POST['x']=='z')
                header("location: result.php");
    }
    else
    {
        unset_cookie_except_session();
    }
?>

<!-- Header -->
 
<header class="w3-display-container  " style="">
  <img class="w3-image m" src="tropical-island2.jpg" alt="Island" style=" width:100%;object-fit: cover;min-height:700px;max-height:1400px;">
    
  <div class="w3-display-middle w3-card-8" style="top:40%;">
    <ul class="w3-navbar w3-blue" >
      <li><a href="javascript:void(0)" class="tablink" onclick="openLink(event, 'Flight');"><i class="fa fa-plane w3-margin-right"></i>Flight</a></li>
      <!--<li><a href="javascript:void(0)" class="tablink" onclick="openLink(event, 'Hotel');"><i class="fa fa-bed w3-margin-right"></i>Hotel</a></li>
      <li><a href="javascript:void(0)" class="tablink" onclick="openLink(event, 'Car');"><i class="fa fa-car w3-margin-right"></i>Rental</a></li>-->
    </ul>

      <div id="Flight" class="container w3-white w3-padding-16 " style="min-width:400px; max-width:1000px;">
     <form id="form" action="" method="post">
      <div class="w3-row-padding" style="margin:0 -16px;">
        <table style="width:100%">
            <tr>
                <td style="width:46%">
              <label>Z</label>
                    <select class="w3-input w3-border klikniecie" id="DepartureCity" name="DepartureCity" placeholder="Departing from">
            
              <option disabled selected value> Wybierz miasto </option>
              <?php foreach($city as $c){?>
              <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
              <?php
            }
            ?>

                </select>
            </td>
            <td style="width:5%">
          
                <button 
                        type="button"  onclick="switchCity()"  style="padding=10px 10px;width=10px;background-color:transparent; margin-top:20px"
                        >
                    <img src="switch.jpg" alt="Submit" width="100%" ></button>
            </td>
            <td style="width:46%">
              <label>Do</label>

              <select class="w3-input w3-border klikniecie"  id="ArrivalCity" placeholder="Arriving at"  name="ArrivalCity" >
               <option disabled selected value> Wybierz miasto </option>
              <?php foreach($city as $c){?>
              <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
              <?php
            }
            ?>
                </select>
            </td>
            </tr>
		</table>
        </div>
	    <fieldset>
          <div class="some-class">
            <input onclick="document.getElementById('date2').disabled = false;" type="radio" class="radio" name="x" value="y" id="y" checked="checked"/>
            <label for="y">Lot w obie strony</label>
            <input onclick="document.getElementById('date2').disabled = true;" type="radio" class="radio" name="x" value="z" id="z" />
            <label for="z">Lot w jedną stronę</label>
          </div>
        </fieldset>
        <!--<div class="w3-half">
            <div class="w3-half">
                <label>Data wylotu: </label><input type="text" id="date" class ="w3-input w3-border">
                <script>$('#date').datepicker({dateFormat: 'dd/mm/yy'});</script>
            </div>
            <div class="w3-half">
                <label>Data powrotu: </label><input type="text" id="date2" class ="w3-input w3-border">
                <script>$('#date2').datepicker({dateFormat: 'dd/mm/yy'});</script>
            </div>
        </div>
        <div class="w3-half">
            <div class="w3-half">
                <label>Liczba osób: </label><input type="number" id="person_number" class ="w3-input w3-border" min="0">
            </div>
            <div class="w3-half">
                <label>Klasa podróży: </label><select class ="w3-input w3-border">
                    <option value="1">Economy</option>
                    <option value="2">Premium</option>
                    <option value="3">Business</option>
                </select>
        </div>-->
		<div class="w3-row-padding" style="margin:0 -16px;">
		<table style="width:100%">
		<tr>
			<td style="width:25%">
				<label>Data wylotu: </label><input type="text" id="date" name="date" class ="w3-input w3-border klikniecie">
				<script>$('#date').datepicker({minDate: 0, dateFormat: 'dd/mm/yy'});</script>
			</td>
			<td style="width:25%">
				<label>Data powrotu: </label><input type="text" id="date2" name="date2" class ="w3-input w3-border klikniecie" style="border-radius:5px" >
                <script>$('#date2').datepicker({
                        minDate:0,
                        onSelect: function (date) {
                            var date1 = $('#date').datepicker('getDate');           
                            var date = new Date( Date.parse( date1 ) ); 
                            date.setDate( date.getDate() + 1 );        
                            var newDate = date.toDateString(); 
                            newDate = new Date( Date.parse( newDate ) );                      
                            $('#date2').datepicker("option","minDate",newDate);  
                            }
                        , dateFormat: 'dd/mm/yy'});</script>
			</td>
			<td style="width:25%">
				 <label>Liczba osób: </label><input type="number" id="person_number" name="person_number" class ="w3-input w3-border klikniecie" min="1" value="1">
			</td>
			<td style="width:25%">
				<label>Klasa podróży: </label><select class ="w3-input w3-border klikniecie" name="flight_class" id="flight_class">
                    <option value="0">Economy</option>
                    <option value="1">Premium</option>
                    <option value="2">Business</option>
                </select>
			</td>
		</tr></table>
		</div>
           <!-- <div class="w3-half">
                <p>Klasa podróży: <input type="text" id="flight_class" class ="w3-input w3-border"></p>
            </div>-->
            <input name="search2" type="submit" value="Szukaj" class="w3-input w3-btn w3-blue" style="float:right;width:22%;margin:1%"  
                   onclick="">
        </form>
		</div>
		
    </div>
      
    <!-- Tabs -->
   
   

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
  <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>



<script>
    
  
function switchCity(){
    var temp = document.getElementById('DepartureCity').value;
    document.getElementById('DepartureCity').value=document.getElementById('ArrivalCity').value;
    document.getElementById('ArrivalCity').value=temp;
}


// Tabs
function openLink(evt, linkName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("myLink");
  for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-blue", "");
  }
  document.getElementById(linkName).style.display = "block";
  evt.currentTarget.className += " w3-blue";
}
// Click on the first tablink on load
document.getElementsByClassName("tablink")[0].click();
</script>

</body>
</html>
<?php ob_flush();?> 