<?php

class Journal {
   public function __construct() {
   }
   
    public function add($date,$ref,$account,$debit,$credit) {
   	global $wpdb;
   	
	$sql = "INSERT INTO ".$wpdb->prefix."bestbooks_journal (txdate,ref,account,debit,credit) VALUES ('$date','$ref','$account','$debit','$credit')";
	$result = $wpdb->query($sql);
	
	if ($result===false) {
	    throw new BestBooksException("Journal record insertion error: ".$sql);
	}
	return "new Journal record added";
    }
   
    public function inBalance() {
       global $wpdb;
       
   	$sql = "SELECT SUM(debit)=SUM(credit) FROM Journal";
   	$result = $wpdb->query($sql);
   	
	if ($result===false) {
	    throw new BestBooksException("Journal balance check error: ".$sql);
	}
	$row = $result->fetchRow();
	return $row[0];
    }
   
    public static function createTable() {
   	global $wpdb;
   	
	//$sql = 'CREATE TABLE `'.$wpdb->prefix.'Journal` (`txdate` DATE NOT NULL,`ref` TINYINT NOT NULL,`account` VARCHAR(50) NOT NULL,`debit` DECIMAL(10,2) NOT NULL,`credit` DECIMAL(10,2) NOT NULL)';
        $sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."bestbooks_journal` (
                        `txdate` date NOT NULL default '0000-00-00',
                        `ref` tinyint(4) NOT NULL default '0',
                        `account` varchar(50) NOT NULL default '',
                        `debit` decimal(10,2) NOT NULL default '0.00',
                        `credit` decimal(10,2) NOT NULL default '0.00'
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$result = $wpdb->query($sql);
	
	if ($result === false) {
	    throw new BestBooksException("Journal table creation error. ".$sql);
	}
	return "Journal table created successfully";
    }
   
    public static function dropTable() {
   	global $wpdb;
   	
   	$sql = "DROP TABLE ".$wpdb->prefix."bestbooks_journal";
	$result = $wpdb->query($sql);
	
	if ($result===false) {
	    throw new BestBooksException("Journal table drop failure");
	}
	return "Journal table dropped successfully";
    }
}


?>