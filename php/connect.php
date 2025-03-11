<?php

function dbConnection()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "skill_swapping";
    $connect = mysqli_connect($host, $username, $password, $db);
    return $connect;
}


?>