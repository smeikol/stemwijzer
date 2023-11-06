<!DOCTYPE html>
<html>
<head>
    <title>CRUD admin</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        padding: 10px;
        background-color: #f2f2f2;
    }

    h2 {
        background-color: #2e3192;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        text-align:center
    }

    form {
        background-color: #fff;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        text-align: center;
    }

    input[type="text"],
    input[type="password"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="submit"] {
        background-color: #2e3192;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: calc(100%);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table, th, td {
        border: 1px solid #ccc;
    }

    th, td {
        padding: 10px;
    }

    th {
        background-color: #2e3192;
        color: #fff;
    }

    .refresh-button {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

   

</style>

</head>

<body>
    <?php
    session_start();
    $CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");

    if (!$CONN) {
        die("Could not connect to the server. Error: " . mysqli_connect_error());
    }

    // CREATE - Admin toevoegen
    if (isset($_POST['create'])) {
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];

        $insertQuery = "INSERT INTO `admin` (`gebruikersnaam`, `wachtwoord`) VALUES ('$gebruikersnaam', '$wachtwoord')";
        if (mysqli_query($CONN, $insertQuery)) {
            echo "Admin is succesvol toegevoegd.";
        } else {
            echo "Fout bij het toevoegen van de admin: " . mysqli_error($CONN);
        }
    }

    // READ - Admins ophalen
$selectQuery = "SELECT admin_id, gebruikersnaam FROM `admin`";
$result = mysqli_query($CONN, $selectQuery);

if ($result) {
    echo "<h2>Beheerderslijst</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Gebruikersnaam</th><th>Actions</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['admin_id'] . "</td>";
        echo "<td>" . $row['gebruikersnaam'] . "</td>";
        echo "<td><a href='?edit=" . $row['admin_id'] . "'>Edit</a> | <a href='javascript:void(0);' onclick='deleteAdmin(" . $row['admin_id'] . ");'>Delete</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Fout bij het ophalen van de beheerders: " . mysqli_error($CONN);
}


    // UPDATE - Admin bijwerken
    if (isset($_GET['edit'])) {
        $adminId = $_GET['edit'];
        // Fetch admin data based on $adminId and pre-fill the edit form.
        $selectEditQuery = "SELECT * FROM `admin` WHERE `admin_id` = $adminId";
        $editResult = mysqli_query($CONN, $selectEditQuery);

        if ($editResult) {
            $editData = mysqli_fetch_assoc($editResult);
            $gebruikersnaam = $editData['gebruikersnaam'];
            $wachtwoord = $editData['wachtwoord'];
        }

        if (isset($_POST['update'])) {
            $updatedGebruikersnaam = $_POST['updated_gebruikersnaam'];
            $updatedWachtwoord = $_POST['updated_wachtwoord'];

            $updateQuery = "UPDATE `admin` SET `gebruikersnaam` = '$updatedGebruikersnaam', `wachtwoord` = '$updatedWachtwoord' WHERE `admin_id` = $adminId";

            if (mysqli_query($CONN, $updateQuery)) {
                echo "Admin is succesvol bijgewerkt. Druk op refresh knop onder aan om de verandering te zien.";
            } else {
                echo "Fout bij het bijwerken van de admin: " . mysqli_error($CONN);
            }
        }
    }

    // DELETE - Admin verwijderen
    if (isset($_GET['delete'])) {
        $adminId = $_GET['delete'];
        $deleteQuery = "DELETE FROM `admin` WHERE `admin_id` = $adminId";
        
        if (mysqli_query($CONN, $deleteQuery)) {
            echo "Admin is succesvol verwijderd.";
            // Na verwijdering, vernieuw de pagina om de wijzigingen te zien.
            echo "<script>window.location = 'admin_crud.php';</script>";
        } else {
            echo "Fout bij het verwijderen van de admin: " . mysqli_error($CONN);
        }
    }

    mysqli_close($CONN);
    ?>

    <h2>Admin toevoegen</h2>
    <form method="POST">
        <label for="gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" name="gebruikersnaam" required>
        <br>
        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" required>
        <br>
        <input type="submit" name="create" value="Admin toevoegen">
    </form>

    <?php if (isset($adminId)): ?>
    <h2>Admin bewerken</h2>
    <form method="POST">
        <label for="updated_gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" name="updated_gebruikersnaam" value="<?php echo isset($gebruikersnaam) ? $gebruikersnaam : ''; ?>" required>
        <br>
        <label for="updated_wachtwoord">Wachtwoord:</label>
        <input type="password" name="updated_wachtwoord" value="<?php echo isset($wachtwoord) ? $wachtwoord : ''; ?>" required>
        <br>
        <input type="submit" name="update" value="Admin bijwerken">
        <button class="refresh-button" onclick="location.reload();">Refresh</button>

    </form>
    <?php endif; ?>
 


    <script>
    function deleteAdmin(adminId) {
        if (confirm("Weet je zeker dat je deze admin wilt verwijderen?")) {
            // Voer de verwijdering uit binnen hetzelfde bestand.
            window.location = "?delete=" + adminId;
        }
    }
    </script>
</body>
</html