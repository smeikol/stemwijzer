<?php
include_once "../../Assets/Templates/Conn.php";

$STATUS = array();
if (empty($_SESSION["Questions"])) {
    $STATUS = array("status" => 0);
    echo json_encode($STATUS);
    return;
}
$array = array($_SESSION["Questions"][0], "status" => 1);
echo json_encode($array);
array_shift($_SESSION["Questions"]);
