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
    	if (getUserIP() == "94.1.154.84") {
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

    function timeSinceUpdate($last_updated) {
        $start_date = new DateTime($last_updated);
        $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

        $mins = $since_start->i;
        $hours = $since_start->h;
        $days = $since_start->d;

        return (($days * 60 * 60) + ($hours * 60) + $mins);
    }

?>