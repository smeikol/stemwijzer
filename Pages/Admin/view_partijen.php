<?php
session_start();

if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id())) {
    header("location: index.php");
}

?>

<!DOCTYPE html>
<html class="admin-fontstyle">

<head>
    <title>CRUD Partijen</title>
    <link rel="stylesheet" href="../../Assets/CSS/admin.css">
</head>

<body class="container admin-background">
<?php
$CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");

if (!$CONN) {
    die("<a class=\"text_white\">Kan nit verbinden met server. Error: " . mysqli_connect_error() . "</a>");
}

if (isset($_GET['verwijderen'])) {
    $partij_id = $_GET['verwijderen'];

    $delete_antwoord_sql = "DELETE FROM partij_antwoord WHERE partij_id=?";
    $delete_antwoord_stmt = $CONN->prepare($delete_antwoord_sql);
    $delete_antwoord_stmt->bind_param("s", $partij_id);
    $delete_antwoord_stmt->execute();

    $delete_partij_sql = "DELETE FROM partij WHERE partij_id=?";
    $delete_partij_stmt = $CONN->prepare($delete_partij_sql);
    $delete_partij_stmt->bind_param("s", $partij_id);
    $delete_partij_stmt->execute();

}

if (isset($_POST['toevoegen'])) {
    $naam = $_POST['naam'];
    $sql = "INSERT INTO partij (naam) VALUES (?)";

    $STMT = $CONN->prepare($sql);
    $STMT->bind_param("s", $naam);
    $STMT->execute();
    $result = $STMT->get_result();

    $party_id = $CONN->insert_id;

    $insert_sql = "INSERT INTO partij_antwoord (partij_id, vraag_id, antwoord) SELECT ?, vraag_id, 0 FROM vraag";
    $insert_stmt = $CONN->prepare($insert_sql);
    $insert_stmt->bind_param("i", $party_id);
    $insert_stmt->execute();

    header("Refresh:0");
}

$sql = "SELECT * FROM partij";
$result = $CONN->query($sql);
?>

<!-- Create - Form to add a new party -->
<h2>Partij toevoegen</h2>
<form method="post">
    <label><a class="text-white">Naam:</a><input type="text" name="naam"></label>
    <input class="action_a toevoeg_button" type="submit" name="toevoegen" value="Toevoegen">
</form>

<!-- Read - List of parties in a table -->
<h2>Partijen</h2>
<?php
if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>Naam</th><th>Actie</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['naam'] . '</td>';
        echo '<td><a class="action_del margin-button" href="?verwijderen=' . $row['partij_id'] . '">Verwijder</a><a class="action_a" href="?bijwerken=' . $row['partij_id'] . '">Updaten</a><a class="action_a" href="partij_vragen.php?partij_id=' . $row['partij_id'] . '">Bekijken</a></td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "<a class=\"text_white\">Geen partijen gevonden.</a>";
}
?>


<!-- Update - Form to update party name -->
<?php
if (isset($_GET['bijwerken'])) {
    $partij_id = $_GET['bijwerken'];
    $sql = "SELECT * FROM partij WHERE partij_id=?";
    $STMT = $CONN->prepare($sql);
    $STMT->bind_param("s", $partij_id);
    $STMT->execute();
    $result = $STMT->get_result();
    $row = $result->fetch_assoc();
    ?>
    <h2>Werk de naam van de partij bij</h2>
    <form method="post">
        <input type="hidden" name="partij_id" value="<?php echo $row['partij_id']; ?>">
        <label><a class="text-white">Nieuwe naam:</a> <input type="text" name="nieuwe_naam" value="<?php echo $row['naam']; ?>"></label>
        <input class="action_a toevoeg_button" type="submit" name="bijwerken" value="Bijwerken">
    </form>
    <?php
}

// Update - Handle the party name update
if (isset($_POST['bijwerken'])) {
    $partij_id = $_POST['partij_id'];
    $nieuwe_naam = $_POST['nieuwe_naam'];

    $sql = "UPDATE partij SET naam=? WHERE partij_id=?";

    $STMT = $CONN->prepare($sql);
    $STMT->bind_param("ss", $nieuwe_naam, $partij_id);
    $STMT->execute();
    $result = $STMT->get_result();

    header("Refresh:0");
}
?>
</body>
</html>