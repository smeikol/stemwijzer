<?php
include_once "../../Assets/Templates/Conn.php";
$partijmatch1naam = "";
$partijmatch1 = 9999999999999999999999999999999999999999999;
$partijmatch3 = 9999999999999999999999999999999999999999999;
$sql = "SELECT * FROM partij";
$stmt = $CONN->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_array()) {
    $partijid = $row['partij_id'];
    $partijnaam = $row['naam'];
    $partijscorey = 0;
    $partijscorex = 0;
    $sql2 = "SELECT * FROM vraag";
    $stmt2 = $CONN->prepare($sql2);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    while ($row2 = $result2->fetch_array()) {
        $vraagid = $row2['vraag_id'];
        $value = $row2['as_keuze'];

        $sql3 = "SELECT * FROM partij_antwoord WHERE vraag_id = ? AND partij_id = ? ";
        $stmt3 = $CONN->prepare($sql3);
        $stmt3->bind_param('ss', $vraagid, $partijid);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        
        while ($row3 = $result3->fetch_array()) {
            if ($value == 0) {
                $partijscorex = $partijscorex + $row3['antwoord'];
            } else if ($value == 1) {
                $partijscorey = $partijscorex + $row3['antwoord'];
            }
        }
    }
 
    $partijdifx = abs($partijscorex - $_GET['xvalue']);
    $partijdify = abs($partijscorey - $_GET['yvalue']);
    $partijdifa = $partijdifx + $partijdify;

    if ($partijmatch1 > $partijdifa){
        $partijmatch2naam = $partijmatch1naam;
        $partijmatch2 = $partijmatch1;
        $partijmatch1 = $partijdifa;
        $partijmatch1naam = $partijnaam;
        
    } 
    else if ($partijmatch2 > $partijdifa) {
        $partijmatch3naam = $partijmatch2naam;
        $partijmatch3 = $partijmatch2;
        $partijmatch2 = $partijdifa;
        $partijmatch2naam = $partijnaam;
    }
    else if ($partijmatch3 > $partijdifa) {
        $partijmatch3 = $partijdifa;
        $partijmatch3naam = $partijnaam;
    }


}

$HTMLPARTY = "1: " . $partijmatch1naam. "<br>" . "2: " . $partijmatch2naam. "<br>" . "3: " . $partijmatch3naam. "<br>";
?>
<!DOCTYPE html>
<html>

<head>
    <title>ROCMN Stemwijzer Resultaten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Assets/CSS/Main.css">
    <link rel="stylesheet" href="../../Assets/CSS/Home.css">
</head>

<body>
    <div class="header">
        <h1>ROCMN Stemwijzer Resultaten</h1>
    </div>

    <div class="border-box">
        <div class="result-section">
            <h2>Jouw Politieke Voorkeuren</h2>
            <ul class="result-list">
                <?php 
                echo $HTMLPARTY;
                ?>
            </ul>
        </div>

        <div class="overwegingen-section">
            <h2>Overwegingen</h2>
            <p>
                Het is belangrijk om deze resultaten te gebruiken als een startpunt voor verdere onderzoek en om meer te
                leren over de partijen en hun programma's. Het is verstandig om de partijen en hun standpunten nader te
                onderzoeken voordat je je uiteindelijke keuze maakt.
            </p>
        </div>
    </div>
</body>

</html>