<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Kiran
 */
class socket {
    private $ip;
    private $port;
    private $socketVar;
    private $socketCon;
    private $socketSendData;
    private $socketRecieveData;
    private $socketSend;
    private $socketRecieve;
    function socket($ip,$port){
        $this->ip=$ip;
        $this->port=$port;
        $this->socketVar = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    }
    public function connect(){
        $this->socketCon = socket_connect($this->socketVar, $this->ip,$this->port);
        if(!$this->socketCon){
            die("Cannot Connnect: Exiting With Exception : ".socket_strerror(socket_last_error()).PHP_EOL);
        }
    }
    public function sendData($data){
        $this->socketSendData = $data;
        $this->socketSend = socket_write($this->socketVar,$this->socketSendData);
    }
    public function recieveData(){
        
    }

}
?>
