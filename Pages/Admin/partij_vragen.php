<?php
session_start();

$CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");
if (!$CONN) {
    die("Connectie niet gelukt ERROR: " . mysqli_connect_error());
}
$partij_id;
if (isset($_GET['partij_id'])) {
    $partij_id = $_GET['partij_id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $antwoorden = $_POST['antwoord'];
        if (is_array($antwoorden)) {
            foreach ($antwoorden as $vraag_id => $antwoord) {
                $sql = "UPDATE partij_antwoord SET antwoord='$antwoord' WHERE partij_id='$partij_id' AND vraag_id='$vraag_id'";
                $result = mysqli_query($CONN, $sql);

                if (!$result) {
                    die("Error: " . mysqli_error($CONN));
                }
            }
            echo "Gelukt.";
        }
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
</head>

<body>



    <form method='post'>
        <table>
            <tr>
                <th>Vraag ID</th>
                <th>Vraag</th>
                <th>Antwoord</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['vraag_id'] ?></td>
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
            <?php endwhile ?>
        </table>
        <input type='submit' value='Submit'>
    </form>
</body>

</html>