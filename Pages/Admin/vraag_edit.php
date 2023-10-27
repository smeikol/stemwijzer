<?php
include_once "../../Assets/Templates/Conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM vraag WHERE vraag_id='$id'";
    $result = $CONN->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $vraag = $_POST['vraag'];

    $sql = "UPDATE vraag SET vraag='$vraag' WHERE vraag_id='$id'";
    if ($CONN->query($sql) === TRUE) {
        header("Location: vragen_crud.php");
    } else {
        echo "Error: " . $sql . "<br>" . $CONN->error;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="../../Assets/CSS/Main.css">
    <link rel="stylesheet" href="../../Assets/CSS/Home.css">
    <link rel="stylesheet" href="../../Assets/CSS/admin.css">
</head>

<body>
    <div class="header">
        <h1>ROCMN Stemwijzer Admin</h1>
    </div>

    <div class="container">
        <h2>Vraag Bewerken</h2>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $row["vraag_id"]; ?>">
            <label for="vraag">Vraag :</label>
            <input type="text" id="vraag" name="vraag" value="<?php echo $row["vraag"]; ?>" required>
            <br>
            <input type="submit" class="btn_opslaan" value="Opslaan" style="cursor: pointer;">
        </form>
    </div>
</body>

</html>
