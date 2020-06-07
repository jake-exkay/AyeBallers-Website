<?php

    include "../includes/connect.php";

    function getUserIP() {
    	$ip = "";
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
    }

    function updatePageViews($connection, $page) {
    	if (getUserIP() == "94.1.154.84" || getUserIP() == "") {
			$stats_query = "UPDATE page_views SET dev_views = dev_views + 1 WHERE page = '$page'";
	                    
	        if ($stats_statement = mysqli_prepare($connection, $stats_query)) {
	            mysqli_stmt_execute($stats_statement);
	        }
    	} else {
    		$stats_query = "UPDATE page_views SET views = views + 1 WHERE page = '$page'";
	                    
	        if ($stats_statement = mysqli_prepare($connection, $stats_query)) {
	            mysqli_stmt_execute($stats_statement);
	        }
    	}
    }

?>