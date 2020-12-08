<?php

    function isLoggedIn($connection) { 
        $ip = getIP();

        $query = "SELECT * FROM user WHERE ip = '$ip' AND logged_in = 1";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getUsername($connection) { 
        $ip = getIP();

        if (isLoggedIn($connection)) {
            $query = "SELECT username FROM user WHERE ip = '$ip' AND logged_in = 1";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row['username'];
                }
            }
        } else {
            return "None";
        }
    }

    function getIP() {
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

    function loginUser($connection, $username) {
        $ip = getIP();
        $query = "UPDATE user SET logged_in = 1, last_login = now(), ip = '$ip' WHERE username = '$username'";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_execute($statement);
            return true;
        } else {
            echo 'Error: failed to update login table.';
            return false;
        }
    }

    function logoutUser($connection) {
        $ip = getIP();
        $query = "UPDATE user SET logged_in = 0 WHERE ip = '$ip'";
        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_execute($statement);
        } else {
            echo 'Error: failed to update login table.'; 
        }
    }

    function userExists($connection, $username) {
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getDBPassword($connection, $username) {
        $query = "SELECT password FROM user WHERE username = '$username'";

        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row['password'];
            }
        }
    }


?>