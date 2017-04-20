<?php
include('base.php');
require_once('signature.php');
//include('signature.php');
session_start();
      
        if(isset($_SESSION['group1']))
          $group1=  test_input($_SESSION['group1']);
        else
        {
            // co jesli z innego powodu niz dokonanie rezerwacji
            if(isset($_COOKIE['group1']))
                header("location:submit.php");
            else
                header("location:index.php");
        }

        if(isset($_SESSION['group2']))
            $group2=test_input($_SESSION['group2']);

        if(isset($_COOKIE['price']))
            $price=test_input($_COOKIE['price']);
   
         $person_number=0;
        
    if(isset($_COOKIE['person_number']))
        $person_number=test_input($_COOKIE['person_number']);

?>
<form type="post" action="submit.php">
<div  id="container2" class="container w3-card-4  w3-white profil" style="min-height:1000px;padding-top:100px;">
   <div  class="20p  w3-card-2" > <div id="right3"  class="row">
                
        
                
            <div id="caption" class="w3-blue caption_padding" style="padding: 8px 10px 8px 10px;">
                        Podsumowanie
            </div>
            <div class ="row" style="border-bottom: 1px solid #ddd;">
            <div id="doP" class="col-xs-6" style="padding: 10px 10px 10px 10px;">
                        
            </div>
                    
            <div id="zP" class="col-xs-6" style="padding: 10px 10px 10px 10px;display:none">
             
                    
            </div>
        </div>
        </div>
    
    
    <div class="row" style="border-bottom: 1px solid #ddd;">
        <div id="pas" style="padding: 10px 10px 10px 10px;border-bottom: 1px solid #ddd;">
                   <span></span>
                        <div><?php 
                            
                            echo "Liczba pasażerów: ". $person_number?></div>
                        <div></div>
        </div>
                    
        <div id="butN" style="padding: 10px 10px 10px 10px;">
            <div class="col-xs-8"></div>
            <div id="price" class="col-xs-4"><?php 
                                echo "<b>Do zapłaty: $price zł<b>";
                            ?>
            </div>
            <div class="col-xs-8"></div>
            <div class="col-xs-4"> <button type="submit" onclick=""class="w3-input w3-btn w3-blue" style="margin-top:20px;margin-bottom:10px;" id ="next" name="next">Zatwierdz</button>
            </div>
        </div>
           
                
    </div>
    </div>
</div>   
    </form>
<!--    <div class="max_width_center" style="margin-top:100px;">
        
            
        <input type="submit" id ="submitButton" name="submitButton">Zatwierdz</button>
        
    </div>
    
-->

</body>
</html>

<?php
   
  if(isset($_SESSION['group2'])){
            echo '<script> document.getElementById("zP").style.display="block";</script>';
                    echo '<script> showFlight('.$group2.',"zP");</script>';
            }  
      echo '<script> showFlight('.$group1.',"doP");</script>';

?>
<script>
   $('form :submit').click( function () {
              $(this).prop("disabled", true).closest('form').append($('<input/>', {
                type: 'hidden',
                name: this.name,
                value: this.value
            })).submit();
          });
    //showFlight(this.value,'zP')
</script>


<?php ob_flush();?> 




