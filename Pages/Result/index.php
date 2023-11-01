<?php
include_once "../../Assets/Templates/Conn.php";

$sql = "SELECT * FROM partij";
$stmt = $CONN->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_array()) {
    $patijid = $row['partij_id'];
    $partijnaam = $row['naam']; 
    
    $sql2 = "SELECT * FROM vraag";
    $stmt2 = $CONN->prepare($sql2);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    while ($row2 = $result2->fetch_array()) {
        $vraagid = $row2['vraag_id'];
        $value = $row2['as_effect'];
    }
}

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

    <div class="result-section">
        <h2>Jouw Politieke Voorkeuren</h2>
        <ul class="result-list">
            <li><strong>PVV:</strong> 100%</li>
            <li><strong>FvD:</strong> 80%</li>
            <li><strong>JA21:</strong> 75%</li>
            <li><strong>SGP:</strong> 50%</li>
            <li><strong>VVD:</strong> 45%</li>
        </ul>
    </div>

    <div class="standpunten-section">
        <h2>Jouw Standpunten</h2>
        <ul class="standpunten-list">
            <li><strong>Standpunt 1:</strong> Voorkeur voor hogere belastingen voor hogere inkomens.</li>
            <li><strong>Standpunt 2:</strong> Ondersteuning van duurzame energie en milieubewuste maatregelen.</li>
            <li><strong>Standpunt 3:</strong> Voorstander van sociale voorzieningen en welzijnsprogramma's.</li>
        </ul>
    </div>

    <div class="overwegingen-section">
        <h2>Overwegingen</h2>
        <p>
            Het is belangrijk om deze resultaten te gebruiken als een startpunt voor verdere onderzoek en om meer te leren over de partijen en hun programma's. Het is verstandig om de partijen en hun standpunten nader te onderzoeken voordat je je uiteindelijke keuze maakt.
        </p>
    </div>
</body>

</html>