<?php
session_start();
include'../classes/db.php';
$db = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', ''.$user.'',''.$pass.'');
$stmt = $db->prepare("SELECT * FROM trackers where id = :uid");
         $stmt->bindValue(':uid', $_GET["tracker"], PDO::PARAM_STR);
				$stmt->execute();
				$trackers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = $db->prepare("SELECT * FROM visiters WHERE time between :sd and :ed AND tracker = :uid ");
         $stmt->bindValue(':uid', $trackers[0]["trackid"], PDO::PARAM_STR);
         $stmt->bindValue(':sd', $_GET["start_date"], PDO::PARAM_STR);
         $stmt->bindValue(':ed', $_GET["end_date"], PDO::PARAM_STR);
         	$stmt->execute();
		$data["rows"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //browsers and os,load time calculations 
                $loadtime=0;
                for($i=0;$i<count($data["rows"]);$i++)
                {
                   $loadtime=$loadtime+$data["rows"][$i]["load_time"];
                }
                $average_load_time=$loadtime/count($data["rows"]);
   	$stmt = $db->prepare("SELECT os,COUNT(os) AS occurrences FROM visiters WHERE time between :sd and :ed AND tracker = :uid GROUP BY os ORDER BY occurrences DESC LIMIT 5");
        $stmt->bindValue(':uid', $trackers[0]["trackid"], PDO::PARAM_STR);
        $stmt->bindValue(':sd', $_GET["start_date"], PDO::PARAM_STR);
        $stmt->bindValue(':ed', $_GET["end_date"], PDO::PARAM_STR); 			
        $stmt->execute();
	$os = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
  $stmt = $db->prepare("SELECT browser,COUNT(browser) AS occurrences FROM visiters WHERE time between :sd and :ed AND tracker = :uid GROUP BY browser ORDER BY occurrences DESC LIMIT 5");
  $stmt->bindValue(':uid', $trackers[0]["trackid"], PDO::PARAM_STR);
         $stmt->bindValue(':sd', $_GET["start_date"], PDO::PARAM_STR);
         $stmt->bindValue(':ed', $_GET["end_date"], PDO::PARAM_STR);       			
         $stmt->execute();
         $browser = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                
                
                
                $counts=0;
               for($i=0;$i<count($data["rows"]);$i++)
               {
                            if($data["rows"][$i]["unique_visitor"]=="1")
                            {
                                $counts++;
                            }
               }
               
               $data["unique"]=$counts;
               $data["browser_data"]=$browser;
               for($i=0;$i<5;$i++)
               {
                            if(!isset($data["browser_data"][$i]))
                            {
                                $push_array=array();
                                $push_array["occurrences"]="100";
                                $data["browser_data"][$i]["occurrences"]=$push_array["occurrences"];
                                unset($push_array);
                            }
                            
               }
               $data["os_data"]=$os;
                echo json_encode($data);
?>
