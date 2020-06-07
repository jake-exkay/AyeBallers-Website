<link rel='icon' href='../../../assets/img/favicon.png' type='image/x-icon'/ >

<?php
    
	include "constants.php";

    $connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
       
    if ($connection->connect_error) {
        echo 'Error connecting to the database';
    }

?>