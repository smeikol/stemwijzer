<?php
include_once "../../Assets/Templates/Conn.php";
if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
    header("Location:index.php?error=U heeft geen toegang tot de admin pagina");
}

$sql = "SELECT * FROM vraag ";
$result = $CONN->query($sql);


if (isset($_GET['vraag_id'])) {
    $id = $_GET['vraag_id'];
    $sql = "DELETE FROM vraag WHERE vraag_id=?";
    $STMT = $CONN->prepare($sql);
    $STMT->bind_param("s", $id);
    $STMT->execute();
    $result = $STMT->get_result();
    while ($row = mysqli_fetch_assoc($result)) {
    
        header("Location: vragen_crud.php");
    }
}
?>