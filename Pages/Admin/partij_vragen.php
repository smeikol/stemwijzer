<?php
session_start();

$CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");
if (!$CONN) {
    die("Connectie niet gelukt ERROR: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['partij_id'])) {
        $partij_id = $_GET['partij_id'];

        $antwoorden = $_POST['antwoord'];

        if (is_array($antwoorden)) {
            foreach ($antwoorden as $vraag_id => $antwoord) {
                $sql = "UPDATE partij_antwoord SET antwoord='$antwoord' WHERE partij_id='$partij_id' AND vraag_id='$vraag_id'";
                $result = mysqli_query($CONN, $sql);

                if (!$result) {
                    die("Error: " . mysqli_error($CONN));
                }
            }
        }

        echo "Gelukt.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php

$sql = "SELECT vraag_id, vraag FROM vraag ORDER BY vraag_id";
$result = mysqli_query($CONN, $sql);

if (!$result) {
    die("Error: " . mysqli_error($CONN));
}

echo "<form method='post'>";
echo "<table>";
echo "<tr><th>Vraag ID</th><th>Vraag</th><th>Antwoord</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['vraag_id'] . "</td>";
    echo "<td>" . $row['vraag'] . "</td>";
    echo "<td>";
    echo "<select name='antwoord[" . $row['vraag_id'] . "]'>";
    echo "<option value='2'>Eens</option>";
    echo "<option value='1'>Beetje mee eens</option>";
    echo "<option value='0'>Neutraal</option>";
    echo "<option value='-1'>Beetje oneens</option>";
    echo "<option value='-2'>Oneens</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo "<input type='submit' value='Submit'>";
echo "</form>";
?>
</body>
</html>