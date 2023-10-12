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
            <label for="username"><b>Gebruikersnaam</b></label>
            <input type="text" placeholder="Gebruikersnaam" name="username" required>
            <br>

            <label for="password"><b>Wachtwoord</b></label>
            <input type="password" placeholder="Wachtwoord" name="password" required>

            <button type="submit">Inloggen</button>
        </form>
    </div>
    <a href="../Home/" class="button" id="btnBack"><button>Terug</button></a>

</body>
</html>