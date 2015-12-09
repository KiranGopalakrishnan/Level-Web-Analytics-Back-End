<?php

/**
 * This class was developed as part of a web project called iconnect which required me to pull data out of a mysql database freequenctly.
 * This class deals with various basic functionalities required for you to pull data out of a database.
 * Only one instance of the class is required for various sub functions which include retrieving using a where claus,Retrieving using Greater than ,Ordered By,Like  
 *
 * @author Kiran
 */
class database {
    private $dbName;
    private $dbUsername;
    private $dbPassword;
    private $dbHostname;
    private $dbVar;
    private $id;
    private $where;
    function database($name,$user,$pass,$host){
        $this->dbName=$name;
        $this->dbUsername=$user;
        $this->dbPassword=$pass;
        $this->dbHostname=$host;
    }
    public function connect(){
        $this->dbVar = new PDO('mysql:host='.$this->dbHostname.';dbname='.$dbName.';charset=utf8', ''.$this->dbUsername.'',''.$this->dbPassword.'');
        return true;
    }
    public function retirve($where,$id){
                $this->id=$id;
                $this->where=$where;
        if($where==" ")
		{
		$stmt = $this->dbVar->prepare("SELECT * FROM ".$this->table);
		$result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$index1=0;
		$order1=array();
			$order1=$result1;
		}
		else
		{
		$stmt = $this->dbVar->prepare("SELECT * FROM ".$this->table." WHERE $where='".$this->id."'");
		$index1=0;
		$order1=array();
		$result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$order1=$result1;

		}
		
		if(!$order1)
		{
			echo "Error Ocuured: Could not retireve from database ;";
		}
		else
		{
			return $order1;
		}
    }
    function retrieveByOrder($where,$id,$ord)
	{
        
                $this->id=$id;
                $this->where=$where;
		if($where==" ")
		{
		
		$stmt = $this->dbVar->prepare("SELECT * FROM ".$this->table." ORDER BY date ".$ord);
		$stmt->execute();
		$order1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			
			$stmt = $this->dbVar->prepare("SELECT * FROM ".$this->table." WHERE $where=:id ORDER BY date ".$ord);
			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt->execute();
			$order1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		if(!$order1)
		{
			exit;
		}
		else
		{
			return $order1;
		}
	}
	function retrieveByGreaterThan($where,$value,$where_second,$value_second,$ord)
	{
		
                $this->id=$id;
                $this->where=$where;
                if($where==" ")
		{
		$stmt = $this->dbVar->prepare("SELECT * FROM ".$this->table." ORDER BY date DESC");
		$index=0;
		$order=array();
		$order = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
	$stmt = $this->dbVar->prepare("SELECT * FROM ".$this->table." WHERE ".$where." > '".$value."' AND ".$where_second."='".$value_second."' ORDER BY post_date ".$ord);
		$index=0;
		$order=array();
		//$order=mysql_fetch_assoc($result);
		$order = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		//$row=mysql_fetch_array($result)
		//$this->numrows=mysql_num_rows($result);
		if(!$order)
		{
			exit;
		}
		else
		{
			return $order;
		}
	}
function retrieveBySimilarity($where,$id)
	{ 
		
                $this->id=$id;
                $this->where=$where;
                $stmt = $this->dbVar->prepare("SELECT * FROM ".$this->table." WHERE ".$where." LIKE '%".$this->id."%' ORDER BY refference ".$ord);
		$index1=0;
		$order1=array();
		$order1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(!$order1)
		{
			exit;
		}
		else
		{
			return $order1;
		}
	}
}
?>
