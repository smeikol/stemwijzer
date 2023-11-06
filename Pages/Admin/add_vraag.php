<?php
include_once "../../Assets/Templates/Conn.php";
if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
    header("Location:index.php?error=U heeft geen toegang tot de admin pagina");
}

$sql = "SELECT * FROM vraag ";
$result = $CONN->query($sql);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vraag = $_POST['vraag'];
    $as_keuze = $_POST['as_keuze'];
    $as_effect = $_POST['as_keuze'];

    $sql = "INSERT INTO vraag (vraag, as_keuze, as_effect) VALUES ('$vraag', '$as_keuze', '$as_effect')";
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
            <label for="as_keuze">As Keuze :</label>
            <input type="number" id="as_keuze" name="as_keuze" required style="width: 40px;" >
            <br>
            <label for="as_effect">As Effect :</label>
            <input type="number" id="as_effect" name="as_effect" required style="width: 40px;">
            <br>
            <input type="submit" value="Aanmaken" style="width: 20%; cursor: pointer;">
        </form>
    </div>
</body>

</html>