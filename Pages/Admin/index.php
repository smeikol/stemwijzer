<?php
include_once "../../Assets/Templates/Conn.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username)) {
        header("Location:index.php?error=Gebruikersnaam is verplicht");
        exit();
    } else if (empty($password)) {
        header("Location:index.php?error=Wachtwoord is verplicht");
        exit();
    } else {
        $sql = "SELECT * FROM admin WHERE gebruikersnaam=?";
        $STMT = $CONN->prepare($sql);
        $STMT->bind_param("s", $username);
        $STMT->execute();
        $result = $STMT->get_result();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['wachtwoord'])) {
                    $_SESSION['username'] = $row['gebruikersnaam'];
                    $_SESSION['id'] = $row['admin_id'];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['sessionid'] = session_id();
                    header("Location: admin.php");
                    exit();
                } else {
                    header("Location:index.php?error=Onjuiste gebruikersnaam of wachtwoord");
                    exit();
                }
            }
        } else {
            header("Location:index.php?error=Onjuiste gebruikersnaam of wachtwoord");
            exit();
        }
    }
}

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
        <h1>ROCMN Stemwijzer Admin</h1>
    </div>

    <div class="Content">
        <h2>Inloggen</h2>
        <form action="index.php" method="post">
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label for="username"><b>Gebruikersnaam</b></label> <br>
            <input type="text" placeholder="Gebruikersnaam" name="username" required>
            <br>

            <label for="password"><b>Wachtwoord</b></label> <br>
            <input type="password" placeholder="Wachtwoord" name="password" required>
            <br>
            <button type="submit">Inloggen</button>
        </form>
    </div>
    <a href="../Home/" class="button" id="btnBack"><button>Terug</button></a>

</body>

</html>