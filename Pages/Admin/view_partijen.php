<!DOCTYPE html>
<html class="admin-fontstyle">
<head>
    <title>CRUD Partijen</title>
    <link rel="stylesheet" href="../../Assets/CSS/admin.css">
</head>
<body class="container admin-background">
    <?php
    session_start();

    $CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");

    if (!$CONN) {
        die("<a class=\"text_white\">Kan nit verbinden met server. Error: " . mysqli_connect_error() . "</a>");
    }

    // Create - Party adding to the database
    if (isset($_POST['toevoegen'])) {
        $naam = $_POST['naam'];
        $sql = "INSERT INTO partij (naam) VALUES ('$naam')";
        if ($CONN->query($sql) === TRUE) {
            echo "<a class=\"text_white\">Partij toegevoegd.</a>";
            header("Refresh:0");
        } else {
            echo "<a class=\"text_white\">Error tijdens partij toevoegen: " . $CONN->error . "</a>";
        }
    }

    // Read - Fetch parties from the database
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
            echo '<td><a class="action_del" href="?verwijderen=' . $row['partij_id'] . '">Verwijder</a><a class="action_a" href="?bijwerken=' . $row['partij_id'] . '">Updaten</a><a class="action_a" href="partij_vragen.php?partij_id=' . $row['partij_id'] . '">Bekijken</a></td>';
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
        $sql = "SELECT * FROM partij WHERE partij_id='$partij_id'";
        $result = $CONN->query($sql);
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

        $sql = "UPDATE partij SET naam='$nieuwe_naam' WHERE partij_id='$partij_id'";

        if ($CONN->query($sql) === TRUE) {
            echo "<a class=\"text-white\">Partij naam succesvol veranderd.</a>";
            header("Refresh:0");
        } else {
            echo "<a class=\"text-white\">Error updaten partij naam: " . $CONN->error . "</a>";
        }
    }

    // Delete - Remove party from the database
    if (isset($_GET['verwijderen'])) {
        $partij_id = $_GET['verwijderen'];
        $sql = "DELETE FROM partij WHERE partij_id='$partij_id'";
        if ($CONN->query($sql) === TRUE) {
            echo "<a class=\"text-white\">Partij naam succesvol verwijderd.</a>";
            header("Location: view_partijen.php");
        } else {
            echo "<a class=\"text-white\">Error vewijderen van partij: " . $CONN->error . "</a>";
        }
    }
    ?>
</body>
</html>
