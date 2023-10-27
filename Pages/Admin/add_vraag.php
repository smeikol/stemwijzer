<?php
include_once "../../Assets/Templates/Conn.php";

$sql = "SELECT * FROM vraag ";
$result = $CONN->query($sql);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vraag = $_POST['vraag'];

    $sql = "INSERT INTO vraag (vraag) VALUES ('$vraag')";
    if ($CONN->query($sql) === TRUE) {
        header("Location: vragen_crud.php");
    } else {
        echo "Error: " . $sql . "<br>" . $CONN->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD | Vraag Aanmaken</title>
    <link rel="stylesheet" href="../../Assets/CSS/Main.css">
    <link rel="stylesheet" href="../../Assets/CSS/Home.css">
    <link rel="stylesheet" href="../../Assets/CSS/admin.css">
</head>

<body>

    <div class="header">
        <h1>ROCMN Stemwijzer Admin</h1>
    </div>

    <div class="container">
        <br>
        <h1>Nieuwe Vraag Toevoegen</h1>
        <br>
        <form method="post">
            <label for="vraag">Vraag :</label>
            <input type="text" id="vraag" name="vraag" required>
            <br>

            <input type="submit" value="Aanmaken" style="width: 20%; cursor: pointer;">
        </form>
    </div>
</body>

</html>