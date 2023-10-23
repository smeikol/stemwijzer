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
<div class="header">
    <h1>Admin page pending</h1>
</div>
<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo "Welkom bij de admin pagina, " . htmlspecialchars($_SESSION['username']) . "!";
} else {
    echo "U moet eerst inloggen voordat u deze pagina mag bekijken.";
}
?>
<a href="logout.php" class="button"><button>Logout</button></a>
</body>
</html>

