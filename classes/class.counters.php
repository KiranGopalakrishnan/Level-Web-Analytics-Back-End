<?php
class counters{
    private $recievedKey;   //Key provided by the user
    private $recievedName;  //Name provided by the user
    private $generatedKey;
    private $generatedDate;
    function counters($counterName,$counterKey){
        if(isset($counterKey))
       $this->recievedKey=$counterKey; 
        $this->recievedName=$counterName;
    }
    public function createCounter($counterName){
        
    }
    
}
?>
