<?php
	include "../../includes/connect.php";
    include "../../includes/constants.php";
    include "../../functions/functions.php";

    function isLoggedIn($connection) { 
    	$ip = getUserIP();

    	$query = "SELECT * FROM staff WHERE IP = '$ip' AND logged_in = 1";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function loginUser($connection) {
    	$ip = getUserIP();
    	if (userExists($connection, $ip)) {
    		$query = "UPDATE staff SET logged_in = 1, last_login = now() WHERE IP = '$ip'";

	        if($statement = mysqli_prepare($connection, $query)) {
	            mysqli_stmt_execute($statement);
	        } else {
	            echo 'Error: failed to update login table.'; 
	        }
    	} else {
    		$query = "INSERT INTO staff (IP, logged_in, last_login)
                  VALUES (?, ?, now())";
	        $one = 1;

	        if($statement = mysqli_prepare($connection, $query)) {
	            mysqli_stmt_bind_param($statement, "si", $ip, $one);
	            mysqli_stmt_execute($statement);
	        } else {
	            echo 'Error: failed to update login table.'; 
	        }
    	}
    }

    function logoutUser($connection) {
    	$ip = getUserIP();
		$query = "UPDATE staff SET logged_in = 0 WHERE IP = '$ip'";
        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_execute($statement);
        } else {
            echo 'Error: failed to update login table.'; 
        }
    }

    function userExists($connection, $ip) {
    	$query = "SELECT * FROM staff WHERE IP = '$ip'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

?>