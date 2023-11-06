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
    <a href="view_partijen.php" class="button">
        <button>Bekijk de partijen</button>
    </a>
    <a href="vragen_crud.php" class="button">
        <button>Bekijk de stellingen</button>
    </a>
</div>

</body>
</html>

