<?php
include_once "../../Assets/Templates/Conn.php";

if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
    header("Location:index.php?error=U heeft geen toegang tot de admin pagina");
}

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

<body class="admin-background">
    <div class="header">
        <h1>ROCMN Stemwijzer Admin</h1>
    </div>
    <?php
    include_once "navbar.php";
    ?>
    <div class="container">
        <h2>Overzicht</h2>

        <a href="add_vraag.php" id="add_vraag">Vraag Toevoegen</a>

        <table>
            <tr>
                <th>Nummer</th>
                <th>Vraag</th>
                <th>Actie</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $counter . "</td>";
                    echo "<td>" . $row["vraag"] . "</td>";
                    echo "<td>
                            <a href='vraag_edit.php?id=" . $row["vraag_id"] . "' class='action_a'>Bewerken</a>
                            <a href='vraag_del.php?vraag_id=" . $row["vraag_id"] . "' class='action_del' onclick='return confirmDelete()'>Verwijderen</a>
                            <a href='Vraagpartijantwoord.php?vraag_id=" . $row["vraag_id"] . "' class='action_a'>Beantwoorden als partij</a>
                         </td>";
                    echo "</tr>";
                    $counter++;
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