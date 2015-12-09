<?php
class eye
{
        private $trackerid;
        private $userid;
        private $source;
        private $destination;
	private $event;
	private $activity;
	private $duration;
	private $ip;
	private $location;
	private $connection_speed;
	private $connection_provider;
	private $element;
        private $elementid;
	private $device;
        private $country;
        private $region;
        private $city;
        private $longitude;
        private $latitude;
        private $time;
        private $load_time;
        private $insertid;
        private $hash;
        private $os;
        private $osVersion;
        private $browser;
        private $browserVersion;
        private $flash;
        private $screen;
        private $unique_hash;
        private $session;
        private $unique_check;
	function eye($trackid,$userid,$type,$con_speed,$con_provider,$device,$os,$osVersion,$browser,$browserVersion,$flash,$screen,$loading_time,$element,$elementid)
	{
            session_start();
                $this->trackerid=$trackid;
                $this->userid=$userid;
		$this->activity=$type;
		$this->device=$device;
                $this->connection_speed=$con_speed;
                $this->connection_provider=$con_provider;
                $this->element =$element;
                $this->duration=date("Y-m-d h:i:s");
                $this->time=date("Y-m-d h:i:s");
                $this->elementid=$elementid;
                $this->event="";
                $this->os=$os;
                $this->osVersion=$osVersion;
                $this->browser=$browser;
                $this->browserVersion=$browserVersion;
                $this->flash=$flash;
                $this->screen=$screen;
                $this->load_time=$loading_time;
	}
	function add_to_server()
	{
            $trackercheck=$this->confirm_tracker();
            
            if($trackercheck==false)
            {
                Echo "Error 1001 : Fatal Error : Tracker Not Found ! Please Check Your Tracker Id";  
            }
            else{
                $this->get_location();
                $this->get_referer();
				$hashid=$this->read_unqiue();
				if($hashid=="1")
				{
					$this->unique_hash=$_COOKIE["anoudis_user_cookie"];
				}
				
		include'db.php';
		 $stmt = $db->prepare("INSERT INTO `tracks`(`trackid`, `userid`, `hash`, `session`, `source`, `destination`, `ip`, `element`, `event`, `element_id_type`, `country`, `city`, `region`, `time`, `duration`, `longitude`, `latitude`, `status`) VALUES (:tid,:uid,:hash,:session,:source,:destination,:ip,:element,:event,:elementid,:country,:city,:region,:time,:duration,:longitude,:latitude,:status)");
                                $stmt->bindValue(':tid', $this->trackerid, PDO::PARAM_STR);
                                $stmt->bindValue(':uid', $this->userid, PDO::PARAM_STR);
				$stmt->bindValue(':source', $this->source, PDO::PARAM_STR);
				$stmt->bindValue(':hash', $this->hash, PDO::PARAM_STR);
                                $stmt->bindValue(':session', $this->session, PDO::PARAM_STR);
                                $stmt->bindValue(':destination', $this->destination, PDO::PARAM_STR);
				$stmt->bindValue(':ip', $this->ip, PDO::PARAM_STR);
                                $stmt->bindValue(':element', $this->element, PDO::PARAM_STR);
				$stmt->bindValue(':event', $this->event, PDO::PARAM_STR);
                                $stmt->bindValue(':elementid', $this->elementid, PDO::PARAM_STR);
				$stmt->bindValue(':country', $this->country, PDO::PARAM_STR);
                                $stmt->bindValue(':city', $this->city, PDO::PARAM_STR);
				$stmt->bindValue(':region', $this->region, PDO::PARAM_STR);
                                $stmt->bindValue(':time', $this->time, PDO::PARAM_STR);
				$stmt->bindValue(':duration', $this->duration, PDO::PARAM_STR);
                                $stmt->bindValue(':latitude', $this->latitude, PDO::PARAM_STR);
				$stmt->bindValue(':longitude', $this->longitude, PDO::PARAM_STR);
                                $stmt->bindValue(':status', "0", PDO::PARAM_STR);		
                                $stmt->execute() or die(print_r($stmt->errorInfo(),true));                
				//echo "err";
                }
	
	}
        function confirm_tracker()
        {
            include'db.php';
		$db = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', ''.$user.'',''.$pass.'');
		$stmt = $db->prepare("SELECT * FROM trackers WHERE trackid = :tid AND userid = :uid");
                                $stmt->bindValue(':tid', $this->trackerid, PDO::PARAM_STR);
                                $stmt->bindValue(':uid', $this->userid, PDO::PARAM_STR);
				$stmt->execute();
				$tracker = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                //var_dump($tracker);
                                if(count($tracker)>0)
                                {
                                    return true;
                                }
                                else
                                {
                                    return false;
                                }
        }
         function set_cook()
        {
            setcookie(
  "anoudis_user_cookie",
  $this->hash,
  time()+3600 * 24 * 365
);
        }
        function track_visiters()
        {
            $this->set_session();
                $unique=$this->read_unqiue();
				 if($unique=="1")
				 {
					 $this->hash=$_COOKIE["anoudis_user_cookie"];
				 }
                                 
                
                                 else{
                                     $this->set_cook();
                                 }
                $this->get_location();
                $this->get_referer();
         	 $trackercheck=$this->confirm_tracker();
                 
                                  echo $unique;   
                 //echo $unique;
                                 //$keyword=$this->extract_keyword();
                                 //$domain=$this->get_tlds($this->source);
                                 //var_dump($keyword);
                                // var_dump($domain);
            if($trackercheck==false)
            {
                Echo "Error 1001 : Fatal Error : Tracker Not Found ! Please Check Your Tracker Id";  
            }
            else{
                include'db.php';
		$db = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', ''.$user.'',''.$pass.'');
		$stmt = $db->prepare("INSERT INTO `visiters`(`tracker`, `hash`, `session`, `source`, `destination`, `duration`, `unique_visitor`, `ip`, `country`, `city`, `latitude`, `longitude`, `time`, `region`, `con_speed`, `load_time`, `os`, `os_version`, `browser`, `browser_version`, `screen_size`, `flash_version`, `status`) VALUES (:tid,:hash,:session,:source,:destination,:duration,:unique,:ip,:country,:city,:latitude,:longitude,:time,:region,:con_speed,:load_time,:os,:osVersion,:browser,:browserVersion,:flash,:screen,:status)");
                                $stmt->bindValue(':tid', $this->trackerid, PDO::PARAM_STR);
				$stmt->bindValue(':source', $this->source, PDO::PARAM_STR);
                                $stmt->bindValue(':destination', $this->destination, PDO::PARAM_STR);
				$stmt->bindValue(':ip', $this->ip, PDO::PARAM_STR);
                                $stmt->bindValue(':unique', $unique, PDO::PARAM_STR);
				$stmt->bindValue(':country', $this->country, PDO::PARAM_STR);
                                $stmt->bindValue(':city', $this->city, PDO::PARAM_STR);
				$stmt->bindValue(':region', $this->region, PDO::PARAM_STR);
                                $stmt->bindValue(':time', $this->time, PDO::PARAM_STR);
				$stmt->bindValue(':duration', $this->duration, PDO::PARAM_STR);
                                $stmt->bindValue(':latitude', $this->latitude, PDO::PARAM_STR);
				$stmt->bindValue(':longitude', $this->longitude, PDO::PARAM_STR);
                                $stmt->bindValue(':con_speed', $this->connection_speed, PDO::PARAM_STR);
                                $stmt->bindValue(':load_time', $this->load_time, PDO::PARAM_STR);
                                $stmt->bindValue(':os', $this->os, PDO::PARAM_STR);
                                $stmt->bindValue(':osVersion', $this->osVersion, PDO::PARAM_STR);
                                $stmt->bindValue(':browser', $this->browser, PDO::PARAM_STR);
                                $stmt->bindValue(':browserVersion', $this->browserVersion, PDO::PARAM_STR);
                                $stmt->bindValue(':flash', $this->flash, PDO::PARAM_STR);
                                $stmt->bindValue(':screen', $this->screen, PDO::PARAM_STR);
                                $stmt->bindValue(':hash', $this->hash, PDO::PARAM_STR);
                                $stmt->bindValue(':session', $this->session, PDO::PARAM_STR);
                                $stmt->bindValue(':status', "0", PDO::PARAM_STR);		
                                $stmt->execute() or die(print_r($stmt->errorInfo(),true)); 
                              //  $this->insertid = $db->lastInsertId();
                               
                                
                                
                                
            }
        }
        function get_location()
        {
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $this->ip=$ip;
            $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
            $this->city=$details->city;
            $this->country=$details->country;
            $this->region=$details->region;
            $this->connection_provider=$details->hostname;
            $cord=explode(",",$details->loc);
            $this->latitude=$cord[0];
            $this->longitude=$cord[1];
        }
        function get_referer()
        {
           $this->source="http://google.com/wert/qwrts";//$_SERVER['HTTP_REFERER'];
        }
        function send_duration( )
        {
            
        }
        function set_session()
        {
            $date=new DateTime();
            $timestamp=$date->getTimestamp();
              
              $this->insertid = $this->generateRandomString();
              $this->hash=md5($timestamp.$this->insertid);
              $_SESSION["anoudis_tracking_session_id"]=$this->hash;
              $this->session=$_SESSION["anoudis_tracking_session_id"];
              
        }
       
        function read_unqiue()
        {
            if (isset($_COOKIE["anoudis_user_cookie"]))
            {
                $this->unique_hash = $_COOKIE["anoudis_user_cookie"];
                return "1";
            }
            else
            {
                return "0";
            }
        }
        
        function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
       $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}

function extract_keyword($url = false) { 
    if(!$url) {
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
    }
    if($url == false) {
        return '';
    }
 
    $parts = parse_url($url);
    parse_str($parts['query'], $query);
    $search_engines = array(
        'bing' => 'q',
        'google' => 'q',
        'yahoo' => 'p'
    );

    preg_match('/(' . implode('|', array_keys($search_engines)) . ')\./', $parts['host'], $matches);

    return isset($matches[1]) && isset($query[$search_engines[$matches[1]]]) ? $query[$search_engines[$matches[1]]] : '';

}


}

?>
