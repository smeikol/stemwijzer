<?php
include_once "../../Assets/Templates/Conn.php";

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
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo "<h1>Welkom bij de admin pagina!</h1>";
} else {
    header("Location:index.php?error=U heeft geen toegang tot de admin pagina");
}
include_once "navbar.php";
?>
</div>
<div class="Content">
    <a href="view_partijen.php" class="button">
        <button>Bekijk de partijen</button>
    </a>
    <a href="vragen_crud.php" class="button">
        <button>Bekijk de stellingen</button>
    </a>
</div>

<a href="logout.php" class="button"><button>Logout</button></a>
</body>
</html>

