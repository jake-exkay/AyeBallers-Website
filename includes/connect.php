<?php

/**
 * Includes file containing connections to MySQL and MongoDB databases.
 *
 * @category Includes
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */
    
include "constants.php";

$connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
   
if ($connection->connect_error) {
    echo 'Error connecting to the database';
}

$mongo_mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

?>