<?php
include_once "../../Assets/Templates/Conn.php";

$STATUS = array();
if (empty($_SESSION["Questions"])) {
    $STATUS = array("status" => 0);
    echo json_encode($STATUS);
    return;
}
echo json_encode($_SESSION["Questions"][0]);
array_shift($_SESSION["Questions"]);
