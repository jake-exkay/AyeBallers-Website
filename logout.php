<?php

include "admin/functions/login_functions.php";
include "includes/connect.php";

if (isLoggedIn($connection)) {
    logoutUser($connection);
    header("Refresh:0.05; url=index.php");
} else {
    header("Refresh:0.05; url=index.php");
}

?>