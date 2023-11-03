<?php
include_once "../../Assets/Templates/Conn.php";

$sql = "SELECT * FROM vraag ";
$result = $CONN->query($sql);

?>
<!DOCTYPE html>
<html lang="nl" class="admin-background">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD | Vragen</title>
    <link rel="stylesheet" href="../../Assets/CSS/Main.css">
    <link rel="stylesheet" href="../../Assets/CSS/Home.css">
    <link rel="stylesheet" href="../../Assets/CSS/admin.css">
</head>

<body>
    <div class="header">
        <h1>ROCMN Stemwijzer Admin</h1>
    </div>

    <div class="container">
        <h2>Overzicht</h2>

        <a href="add_vraag.php" id="add_vraag">Vraag Toevoegen</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Vraag</th>
                <th>Actie</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["vraag_id"] . "</td>";
                    echo "<td>" . $row["vraag"] . "</td>";
                    echo "<td>
                            <a href='vraag_edit.php?id=" . $row["vraag_id"] . "' class='action_a'>Bewerken</a>
                            <a href='vraag_del.php?vraag_id=" . $row["vraag_id"] . "' class='action_del' onclick='return confirmDelete()'>Verwijderen</a>
                         </td>";
                    echo "</tr>";
                }
            } else {
                echo "Geen resultaten";
            }
            ?>
        </table>
    </div>
</body>

</html>

<script>
    function confirmDelete() {
        return confirm("Weet je zeker dat je deze vraag wilt verwijderen?");
    }
</script>