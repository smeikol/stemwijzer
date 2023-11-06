<?php
include_once "../../Assets/Templates/Conn.php";
if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
    header("Location:index.php?error=U heeft geen toegang tot de admin pagina");
}

$sql = "SELECT * FROM vraag ";
$result = $CONN->query($sql);


if ($_SERVER["REQUEST_METHOD"] == "POST") {



    $vraag = $_POST['vraag'];
    $as_keuze = $_POST['as_keuze'];

    if ($_POST['currentas'] == 1){ 
    $as_effect = $_POST['as_effect1'];
    }
    else{
    $as_effect = $_POST['as_effect2'];
    }
    $sql = "INSERT INTO vraag (vraag, as_keuze, as_effect) VALUES (?, ?, ?)";
    $STMT = $CONN->prepare($sql);
    $STMT->bind_param("sss", $vraag, $as_keuze, $as_effect);
    $STMT->execute();
    $result = $STMT->get_result();
    header("Location: vragen_crud.php");
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD | Vraag Aanmaken</title>
    <link rel="stylesheet" href="../../Assets/CSS/Main.css">
    <link rel="stylesheet" href="../../Assets/CSS/Home.css">
    <link rel="stylesheet" href="../../Assets/CSS/admin.css">
</head>

<body>

    <div class="header">
        <h1>ROCMN Stemwijzer Admin</h1>
    </div>

    <div class="container">
        <br>
        <h1>Nieuwe Vraag Toevoegen</h1>
        <br>
        <form method="post">
            <label for="vraag">Vraag :</label>
            <input type="text" id="vraag" name="vraag" required>
            <br>
            <label for="as_keuze">Standpuntensoort:</label>
            <select name="as_keuze" id="as_keuze">
                <option value="0">Link/Rechts</option>
                <option value="1">Progressief/Conservatief</option>
            </select>
            <br>
            <label for="as_effect">Richting:</label>
            <select name="as_effect1" class="as_effect" id="as_effect1" style="display: inline-block;">
                <option value="-2">Links</option>
                <option value="2">Rechts</option>
            </select>
            <select name="as_effect2" class="as_effect" id="as_effect2" style="display: none;"> 
                <option value="-2">Conservatief</option>
                <option value="2">Progressief</option>
            </select>
            <br>
            <input type="hidden" id="currentas" name="currentas" value="1">
            <input type="submit" value="Aanmaken" style="width: 20%; cursor: pointer;">
        </form>
    </div>


    <script> const as_keuze = document.getElementById('as_keuze');
    as_keuze.addEventListener('change', checkdropdown);
    
    function checkdropdown() {

        const as_effect1 = document.getElementById('as_effect1');
        const as_effect2 = document.getElementById('as_effect2');
        const hiddenboxy = document.getElementById('currentas');
        const droppy1 = parseInt(as_keuze.value);

        if (droppy1 == 0) {
            as_effect1.style.display = 'inline-block';
            as_effect2.style.display = 'none';
            hiddenboxy.value = 1;
        }

        if (droppy1 == 1) {
            as_effect1.style.display = 'none';
            as_effect2.style.display = 'inline-block';
            hiddenboxy.value = 2;
        }
    }
    </script>
</body>

</html>