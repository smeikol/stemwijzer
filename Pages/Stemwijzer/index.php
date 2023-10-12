<?php
include "../../Assets/Templates/Conn.php";

$STMT = $CONN->query("SELECT * FROM `vraag`");
if (!$STMT) die("False statement");

$QUESTION = $STMT->fetch_row();
$_SESSION["Questions"] = $STMT->fetch_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Assets/CSS/Main.css">
    <link rel="stylesheet" href="../../Assets/CSS/Stemwijzer.css">
    <title>Stemwijzer</title>
</head>

<body>
    <div class="QuestionWrapper">
        <p id="QuestionHeader">[Question]</p>
        <div class="Options">
            <label>
                <input name="Choice" type="radio">Niet mee eens
            </label>
            <label>
                <input name="Choice" type="radio">Beetje niet mee eens
            </label>
            <label>
                <input name="Choice" type="radio">Neutraal
            </label>
            <label>
                <input name="Choice" type="radio">Beetje mee eens
            </label>
            <label>
                <input name="Choice" type="radio">Mee eens
            </label>
        </div>
    </div>
    <div class="NavButtons">
        <button class="BackButton">Back</button>
        <button class="NextButton DissabledButtons">Next</button>
    </div>
</body>

</html>