<?php
include('base.php');
?>
<style>
.center{
    position:absolute;
    left:50%;
    top:50%;
	
	transform:translate(-50%,-50%);
}

</style>
<div class="center">
    <div class="text-center" style="margin-top:-20%;margin-bottom:50px;font-size:30px;">
        <?php
            if(isset($_GET['brak1']))
                echo "Niestety brak miejsc lot 1";
            else if(isset($_GET['brak2']))
                echo "Niestety brak miejsc lot 2";
            else
                echo "Coś poszło nie tak";
        ?>
        
       
    </div>
<img src="1.png" height="333px" width="333px" >
    </div>
</body>
</html>