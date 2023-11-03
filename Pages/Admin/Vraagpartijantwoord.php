<?php
include_once "../../Assets/Templates/Conn.php";

$counter = 0;
$vraagid = $_GET['id'];

$sql3 = "SELECT * FROM vraag WHERE vraag_id = ?";
$stmt3 = $CONN->prepare($sql3);
$stmt3->bind_param('s', $vraagid);
$stmt3->execute();
$result3 = $stmt3->get_result();

if (isset($_POST['submit'])) {



}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="vraagpartijantwoord.php?id=<?php echo $vraagid ?>">
        <?php
        while ($row3 = $result3->fetch_array()) {

            $sql = "SELECT * FROM partij";
            $stmt = $CONN->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_array()) {
                $partijid = $row['partij_id'];
                $partijnaam = $row['naam'];
                $sql2 = "SELECT * FROM partij_antwoord WHERE vraag_id = ? AND partij_id = ? ";
                $stmt2 = $CONN->prepare($sql2);
                $stmt2->bind_param('ss', $vraagid, $partijid);
                $stmt2->execute();
                $result2 = $stmt2->get_result();

                while ($row2 = $result2->fetch_array()) {
                    $counter++;
                    echo '<div>' . $partijnaam . '</div>' . '<select name="antwoord'.$counter.'">
        <option value="' . $row3['as_effect'] . '">Mee eens</option>
        <option value="' . $row3['as_effect'] / 2 . '">Beetje mee eens</option>
        <option value="0">Neutraal</option>
        <option value="' . 0 - $row3['as_effect'] / 2 . '">Beetje niet mee eens</option>
        <option value="' . 0 - $row3['as_effect'] . '">Niet mee eens</option>
      </select>';
                }
            }
        }
        ?>
        <button type="submit" name="submit"> opslaan </button>

    </form>
</body>

</html>