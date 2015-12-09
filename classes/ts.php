<?php

session_start();
$_SESSION["userid"]="1";
$userid=$_SESSION["userid"];
include'db.php';
 $stmt = $db->prepare("SELECT * FROM visiters where tracker = :tid");
         $stmt->bindValue(':tid', $trackers[0]["trackid"], PDO::PARAM_STR);
		$stmt->execute();
		$tracks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $counts=array();
                $dates=array();
                $unique=0;
                $counts[0]["count"]=0;
                $counts[0]["unique"]=0;
                $counts[1]["count"]=0;
                $counts[1]["unique"]=0;
                $counts[2]["count"]=0;
                $counts[2]["unique"]=0;
                $counts[3]["count"]=0;
                $counts[3]["unique"]=0;
  for($i=0;$i<4;$i++)
                {
                    
                    $date=date("Y-m-d",strtotime("-".$i." days")); 
                    $dates[$i]["date"]=$date;
                     for($j=0;$j<count($tracks);$j++)
                    {
                        $trackdate=date("Y-m-d",strtotime($tracks[$j]["time"]));
                        if($date==$trackdate)
                        {
                            $counts[$i]["count"]++;  
                            if($tracks[$j]["unique_visitor"]=="1")
                            {
                                $counts[$i]["unique"]++;
                            }
                        
                        }
                    }
                 // echo $date."=".$trackdate;
                }
var_dump($counts);
?>
