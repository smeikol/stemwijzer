<?php
session_start();
if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
    header("Location:index.php?error=U heeft geen toegang tot de admin pagina");
}

$CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");
if (!$CONN) {
    die("Connectie niet gelukt ERROR: " . mysqli_connect_error());
}
$partij_id;
if (isset($_GET['partij_id'])) {
    $partij_id = $_GET['partij_id'];
    if (isset($_POST['submit'])) {

        $antwoorden = $_POST['antwoord'];
        if (is_array($antwoorden)) {
            foreach ($antwoorden as $vraag_id => $antwoord) {
                $sql = "UPDATE partij_antwoord SET antwoord=? WHERE partij_id=? AND vraag_id=?";
                $STMT = $CONN->prepare($sql);
                $STMT->bind_param("sss", $antwoord, $partij_id, $vraag_id);
                $STMT->execute();
                $result = $STMT->get_result();
            }
            echo "Gelukt.";
        }
        header("Location:view_partijen.php");
    }
    $sql = "SELECT * FROM vraag ORDER BY vraag_id";
    $result = mysqli_query($CONN, $sql);
    $sql = "SELECT * FROM partij_antwoord WHERE partij_id = ? ORDER BY vraag_id";
    $STMT = $CONN->prepare($sql);
    $STMT->bind_param("i", $partij_id);
    $STMT->execute();
    $RESULT = $STMT->get_result();
    $patij_antwoorden;
    while ($row = $RESULT->fetch_array()) {
        $patij_antwoorden[$row["vraag_id"]] = $row;
    }
}


if (!$result) {
    die("Error: " . mysqli_error($CONN));
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../../Assets/CSS/partij_vragen.css">
</head>

<body>



    <form method='post'>
        <table>
            <tr>
                <th>Vraag Nummer</th>
                <th>Vraag</th>
                <th>Antwoord</th>
            </tr>

            <?php
            $counter = 1;
            while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $counter ?></td>
                    <td><?php echo $row['vraag'] ?></td>
                    <td>
                        <select name='antwoord[<?php echo $row['vraag_id'] ?>]'>
                            <option value='<?php echo $row["as_effect"] ?>' <?php if ($patij_antwoorden[$row["vraag_id"]]["antwoord"] == $row["as_effect"]) : ?> selected <?php endif ?>>Eens</option>
                            <option value='<?php echo $row["as_effect"] / 2 ?>' <?php if ($patij_antwoorden[$row["vraag_id"]]["antwoord"] == $row["as_effect"] / 2) : ?> selected <?php endif ?>>Beetje mee eens</option>
                            <option value='0' <?php if ($patij_antwoorden[$row["vraag_id"]]["antwoord"] == 0) : ?> selected <?php endif ?>>Neutraal</option>
                            <option value='<?php echo 0 - $row["as_effect"] / 2 ?>' <?php if ($patij_antwoorden[$row["vraag_id"]]["antwoord"] == 0 - $row["as_effect"] / 2) : ?> selected <?php endif ?>>Beetje oneens</option>
                            <option value='<?php echo 0 - $row["as_effect"] ?>' <?php if ($patij_antwoorden[$row["vraag_id"]]["antwoord"] == 0 - $row["as_effect"]) : ?> selected <?php endif ?>>Oneens</option>
                        </select>
                    </td>
                </tr>
            <?php $counter++;
            endwhile ?>
        </table>
        <input type='submit' name='submit'>
    </form>
</body>

</html>