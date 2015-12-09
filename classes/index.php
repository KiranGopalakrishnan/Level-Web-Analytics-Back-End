<?php
echo $_GET["trackerId"];
echo $_GET["userKey"];
include'class.eye.php';
$ey=new eye($_GET["trackerId"],$_GET["userKey"],"click","dsf3","dsf4",$_GET["device"],$_GET["os"],$_GET["osVersion"],$_GET["browser"],$_GET["browserVersion"],$_GET["flash"],$_GET["screen"],$_GET["loading_time"],"","");
        //$ey->add_to_server();
        $ey->track_visiters();
       // echo $_SESSION["anoudis_tracking_session_id"];
?>
