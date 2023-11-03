<!DOCTYPE html>
<html>
<head>
    <title>CRUD Partijen</title>
    <link rel="stylesheet" href="../../Assets/CSS/admin.css">
    <style>

    </style>
</head>
<body class="container admin-background">
    <?php
    session_start();

    $CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");

    if (!$CONN) {
        die("Could not connect to server. Error: " . mysqli_connect_error());
    }

    // Create - Party adding to the database
    if (isset($_POST['toevoegen'])) {
        $naam = $_POST['naam'];
        $sql = "INSERT INTO partij (naam) VALUES ('$naam')";
        if ($CONN->query($sql) === TRUE) {
            echo "Party successfully added.";
        } else {
            echo "Error adding party: " . $CONN->error;
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
        <input type="submit" name="toevoegen" value="Toevoegen">
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
            echo '<td><a class="action_del" href="?verwijderen=' . $row['partij_id'] . '">Verwijderen</a> <a class="action_a" href="?bijwerken=' . $row['partij_id'] . '">Bijwerken</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "Geen partijen gevonden.";
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
        <h2>Werk partije naam bij</h2>
        <form method="post">
            <input type="hidden" name="partij_id" value="<?php echo $row['partij_id']; ?>">
            <label><a class="text-white">Nieuwe naam:</a> <input type="text" name="nieuwe_naam" value="<?php echo $row['naam']; ?>"></label>
            <input type="submit" name="bijwerken" value="Bijwerken">
        </form>
    <?php
    }

    // Update - Handle the party name update
    if (isset($_POST['bijwerken'])) {
        $partij_id = $_POST['partij_id'];
        $nieuwe_naam = $_POST['nieuwe_naam'];

        $sql = "UPDATE partij SET naam='$nieuwe_naam' WHERE partij_id='$partij_id'";

        if ($CONN->query($sql) === TRUE) {
            echo "Party name updated successfully.";
        } else {
            echo "Error updating party name: " . $CONN->error;
        }
    }

    // Delete - Remove party from the database
    if (isset($_GET['verwijderen'])) {
        $partij_id = $_GET['verwijderen'];
        $sql = "DELETE FROM partij WHERE partij_id='$partij_id'";
        if ($CONN->query($sql) === TRUE) {
            echo "Party successfully deleted.";
        } else {
            echo "Error deleting party: " . $CONN->error;
        }
    }
    ?>
</body>
</html>
