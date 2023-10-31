<!DOCTYPE html>
<html>
<head>
    <title>CRUD Partijen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            
            
            
        }
        h2 {
            background-color: #2e3192;
            color: #fff;
            padding: 10px;
        }
        form {
            margin: 10px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #2e3192;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2e3192;
            color: #fff;
        }
        a {
            text-decoration: none;
        }

 /* Kleur voor "Delete" knop */
 .delete-button {
        background-color: #FF5733; /* Rode kleur */
        color: #fff; /* Witte tekst */
        padding: 5px 10px;
        border: none;
        text-decoration: none;
    }

    /* Kleur voor "Update" knop */
    .update-button {
        background-color: #33BFFF; /* Blauwe kleur */
        color: #fff; /* Witte tekst */
        padding: 5px 10px;
        border: none;
        text-decoration: none;
    }



    </style>
</head>
<body>
    <?php
    session_start();

    $CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");

    if (!$CONN) {
        die("Could not connect to server. Error: " . mysqli_connect_error());
    }

    // Rest of your script goes here...

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
    <h2>Add Party</h2>
    <form method="post">
        <label>Name: <input type="text" name="naam"></label>
        <input type="submit" name="toevoegen" value="Add">
    </form>

    <!-- Read - List of parties in a table -->
    <h2>Parties</h2>
    <?php
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Name</th><th>Action</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['naam'] . '</td>';
            echo '<td><a class="delete-button" href="?verwijderen=' . $row['partij_id'] . '">Delete</a> | <a class="update-button" href="?bijwerken=' . $row['partij_id'] . '">Update</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No parties found.";
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
        <h2>Update Party Name</h2>
        <form method="post">
            <input type="hidden" name="partij_id" value="<?php echo $row['partij_id']; ?>">
            <label>New Name: <input type="text" name="nieuwe_naam" value="<?php echo $row['naam']; ?>"></label>
            <input type="submit" name="bijwerken" value="Update">
        </form>
    <?php
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
