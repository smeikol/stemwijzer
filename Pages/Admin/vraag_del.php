<?php
include_once "../../Assets/Templates/Conn.php";

$sql = "SELECT * FROM vraag ";
$result = $CONN->query($sql);


if (isset($_GET['vraag_id'])) {
    $id = $_GET['vraag_id'];
    $sql = "DELETE FROM vraag WHERE vraag_id='$id'";
    if ($CONN->query($sql) === TRUE) {
        header("Location: vragen_crud.php");
    } else {
        echo "Error: " . $sql . "<br>" . $CONN->error;
    }
}
?>