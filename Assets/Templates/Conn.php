<?php
session_start();

$CONN =  mysqli_connect("localhost", "root", "", "stemwijzer_db");

if (!$CONN) {
    die("Could not connect to server. Error: " . mysqli_connect_error());
}
