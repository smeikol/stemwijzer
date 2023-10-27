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
    <title>CRUD System - Create</title>
</head>
<body>
    <h1>Create a New Question</h1>

    <form method="post">
        <label for="question">Question:</label>
        <input type="text" id="question" name="question" required>
        <br>

        <input type="submit" value="Create">
    </form>
</body>
</html>
