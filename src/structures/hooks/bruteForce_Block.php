<?php
class BruteForce_Block {
	public function block_user($db) {
        $ip_user = mysqli_real_escape_string($db, $_SERVER['REMOTE_ADDR']);
        $sqlBlock = sprintf("INSERT INTO `users_attempts` (ip_address, timestamp) VALUES ('%s', CURRENT_TIMESTAMP)", $ip_user);
        mysqli_query($db, $sqlBlock);
    }

    public function verify_block_user($db) { 
        mysqli_query($db,"DELETE FROM `users_attempts` where TIMESTAMPDIFF(SECOND,timestamp,CURRENT_TIMESTAMP) > 1200");

        $sql = sprintf("SELECT COUNT(*) as COUNT from `users_attempts` where ip_address = '%s'",
		mysqli_real_escape_string($db,$_SERVER['REMOTE_ADDR']));

        $result = mysqli_query($db,$sql);
		$row = mysqli_fetch_assoc($result);
		$ipAdd = $_SERVER['REMOTE_ADDR'];
        
        if($row['COUNT'] > 9) {
            return true;
	    }
    }

    public function user_free($db) { 
        $sql = "DELETE FROM `users_attempts` where ip_address = '" . $_SERVER["REMOTE_ADDR"] . "'";
        mysqli_query($db,$sql);
     }
}
?>