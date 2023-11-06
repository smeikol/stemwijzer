<?php
include_once "../../Assets/Templates/Conn.php";

if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
    header("Location:index.php?error=U heeft geen toegang tot de admin pagina");
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $vraag_id = $_GET["id"];
    
    // Fetch the question based on the provided ID
    $sql = "SELECT * FROM vraag WHERE vraag_id = $vraag_id";
    $result = $CONN->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $question = $row["vraag"];
    } else {
        echo "Question not found.";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_question"])) {
    $vraag_id = $_POST["vraag_id"];
    $new_question = $_POST["new_question"];

    // Update the question in the database
    $sql = "UPDATE vraag SET vraag = '$new_question' WHERE vraag_id = $vraag_id";
    if ($CONN->query($sql) === TRUE) {
        header("Location: vragen_crud.php"); // Redirect to the question list after the update
        exit;
    } else {
        echo "Error updating question: " . $CONN->error;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD | Vraag Bewerken</title>
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

        <form method="post" action="">
            <input type="hidden" name="vraag_id" value="<?php echo $vraag_id; ?>">
            <label for="new_question">Nieuwe Vraag :</label>
            <input type="text" name="new_question" value="<?php echo $question; ?>">
            <input type="submit" name="update_question" value="Bijwerken" style="width: 20%; cursor: pointer;">
        </form>
    </div>
</body>

</html>
