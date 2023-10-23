<?php
include_once "../../Assets/Templates/Conn.php";
$DATA = json_decode(file_get_contents("php://input"), true);

if (isset($DATA["status"])) {

    if ($DATA["status"] == "next") {
        $STATUS = array();
        if (empty($_SESSION["Questions"])) {
            $STATUS = array("status" => 0);
            echo json_encode($STATUS);
            return;
        }
        $array = array($_SESSION["Questions"][0], "status" => 1);
        echo json_encode($array);

        array_unshift($_SESSION["PrefQuestions"], $_SESSION["Questions"][0]);
        array_shift($_SESSION["Questions"]);
    }
    if ($DATA["status"] == "back") {
        $STATUS = array();
        array_unshift($_SESSION["Questions"], $_SESSION["PrefQuestions"][0]);
        array_shift($_SESSION["PrefQuestions"]);
        if (empty($_SESSION["PrefQuestions"])) {
            $STATUS = array("status" => 0);
            echo json_encode($STATUS);
            return;
        }
        $array = array($_SESSION["PrefQuestions"][0], "status" => 1);
        echo json_encode($array);
    }
}
