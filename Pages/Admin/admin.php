<?php
include_once "../../Assets/Templates/Conn.php";

//if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id())) {
  //  header("location: index.php");
//}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROCMN Stemwijzer Admin</title>
    <link rel="stylesheet" href="../../Assets/CSS/Main.css">
    <link rel="stylesheet" href="../../Assets/CSS/Home.css">
    <link rel="stylesheet" href="../../Assets/CSS/admin.css">
</head>
<body>
<div class='header'>
<?php
if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
    header("Location:index.php?error=U heeft geen toegang tot de admin pagina");
} else {
    echo "<h1>Welkom bij de admin pagina!</h1>";
}

?>
</div>
<?php
include_once "navbar.php";
?>
<div class="Content">
    <p>
        Welkom op de admin-pagina van de stemwijzer.
        Deze krachtige tool biedt beheerders de mogelijkheid om de stemwijzer-ervaring te optimaliseren en te controleren.
        Als beheerder heb je toegang tot een scala aan functies waarmee je de vragen, partijen en antwoorden kunt beheren.
        Met deze administratieve hub kun je de stemwijzer op maat aanpassen, beleidskwesties bijwerken en zorgen voor een soepele werking van het systeem.
        Laten we samenwerken om de stemwijzer-ervaring te verbeteren en een bijdrage te leveren aan een goed geïnformeerde samenleving
    </p>
</div>
</body>
</html>

