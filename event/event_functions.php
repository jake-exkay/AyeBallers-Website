<?php

    include "../includes/connect.php";

    $participants = array('4995579a28f647dfbc03f33fd2aec058','83f44cd9ca9d4712a6bf9e618574f0de','84baea6eb660472eb9b8b20a3f446346','a82811c82b394da8a7767e28d9248a45','d052e63b70ba454d825326ca80b0ee0d','d1d9c04d16474a3cbb2cc1087747a7d2','56d9ab39794444d7ad77d8f3cb20ac78','718c6eaa52434a0e8f3d6c71b2ba6a0f','9a02fb46b9fa445fba8c5db62c9cbf3b','ff7ce8cdfdf64d3e8f91cad7a063ec53','648b236c66684bfbb622d01be7a2d5b3','60fb367459ae4f48812e16b28d8d8afa','3075f56a40ea4f14b1d754fdfc69f7b6','4abdba1d9b274bf7867d5bb4cda287ba','babaee4d60d34732ad3b6ac0775a5a33','82fc95c49afc4b8182b6cefeac42874e','aa6c6113f2e74be6ac14bd0417de66ff','96e0180e19a2494f8559e9cac1887acd','20f1f6cf342b466784acb60ddd9ee38c','43df06bcff994034b0e9bc7507d1f126');

    function eventStarted($connection) {
        $query = "SELECT * FROM event_management";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $event_started = $row['event_started'];
            }
        }

        if ($event_started == 1) {
            return true;
        } else {
            return false;
        }
    }

    function needsUpdating($connection) {
        $last_updated_query = "SELECT * FROM event_management";
        $last_updated_result = $connection->query($last_updated_query);

        if ($last_updated_result->num_rows > 0) {
            while($last_updated_row = $last_updated_result->fetch_assoc()) {
                $last_updated = $last_updated_row['last_updated'];
            }
        }

        $start_date = new DateTime($last_updated);
        $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

        if ($since_start->i >= 10 || $since_start->y != 0 || $since_start->m != 0 || $since_start->d != 0 || $since_start->h != 0) {
            return true;
        } else {
            return false;
        }
    }

?>