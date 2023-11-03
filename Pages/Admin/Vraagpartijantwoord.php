<?php
session_start();

$CONN = mysqli_connect("localhost", "root", "", "stemwijzer_db");
if (!$CONN) {
    die("Connectie niet gelukt ERROR: " . mysqli_connect_error());
}
$vraag_id;
if (isset($_GET['vraag_id'])) {
    $vraag_id = $_GET['vraag_id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $antwoorden = $_POST['antwoord'];
        if (is_array($antwoorden)) {
            foreach ($antwoorden as $partij_id => $antwoord) {
                $sql = "UPDATE partij_antwoord SET antwoord='$antwoord' WHERE partij_id='$partij_id' AND vraag_id='$vraag_id'";
                $result = mysqli_query($CONN, $sql);

                if (!$result) {
                    die("Error: " . mysqli_error($CONN));
                }
                
            }
        }
        header("Location:vragen_crud.php");
    }
    $sql = "SELECT * FROM partij";
    $result = mysqli_query($CONN, $sql);
    $sql = "SELECT * FROM partij_antwoord WHERE vraag_id = ?";
    $STMT = $CONN->prepare($sql);
    $STMT->bind_param("i", $vraag_id);
    $STMT->execute();
    $RESULT = $STMT->get_result();
    $patij_antwoorden;
    while ($row = $RESULT->fetch_array()) {
        $patij_antwoorden[$row["partij_id"]] = $row;
    }
    
}

$sql3 = "SELECT * FROM vraag WHERE vraag_id = ?";
$stmt3 = $CONN->prepare($sql3);
$stmt3->bind_param('s', $vraag_id);
$stmt3->execute();
$result3 = $stmt3->get_result();

while ($row3 = mysqli_fetch_assoc($result3)) {
    $value = $row3['as_effect'];
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
                <th>Partij ID</th>
                <th>Partij</th>
                <th>Antwoord</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['partij_id'] ?></td>
                    <td><?php echo $row['naam'] ?></td>
                    <td>
                        <select name='antwoord[<?php echo $row['partij_id'] ?>]'>
                            <option value='<?php echo $value ?>' <?php if ($patij_antwoorden[$row["partij_id"]]["antwoord"] == $value) : ?> selected <?php endif ?>>Eens</option>
                            <option value='<?php echo $value / 2 ?>' <?php if ($patij_antwoorden[$row["partij_id"]]["antwoord"] == $value / 2) : ?> selected <?php endif ?>>Beetje mee eens</option>
                            <option value='0' <?php if ($patij_antwoorden[$row["partij_id"]]["antwoord"] == 0) : ?> selected <?php endif ?>>Neutraal</option>
                            <option value='<?php echo 0 - $value / 2 ?>' <?php if ($patij_antwoorden[$row["partij_id"]]["antwoord"] == 0 - $value / 2) : ?> selected <?php endif ?>>Beetje oneens</option>
                            <option value='<?php echo 0 - $value ?>' <?php if ($patij_antwoorden[$row["partij_id"]]["antwoord"] == 0 - $value) : ?> selected <?php endif ?>>Oneens</option>
                        </select>
                    </td>
                </tr>
            <?php endwhile ?>
        </table>
        <input type='submit' value='Submit'>
    </form>
</body>

</html>