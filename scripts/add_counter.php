<?php
$stmt = $db->prepare("INSERT INTO `counters`(`id`, `name`, `key`, `userId`, `date`, `status`) VALUES (:name,:key,:userId,:date,:status)");
                                $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                                $stmt->bindValue(':key', $this->key, PDO::PARAM_STR);
                                $stmt->execute() or die(print_r($stmt->errorInfo(),true));   
?>
