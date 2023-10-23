<?php
include "../../Assets/Templates/Conn.php";

$STMT = $CONN->query("SELECT * FROM `vraag`");
if (!$STMT) die("False statement");

$QUESTION = $STMT->fetch_row();
$_SESSION["PrefQuestions"] = array();
$_SESSION["PrefQuestions"][] = $QUESTION;
$_SESSION["Questions"] = $STMT->fetch_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Assets/CSS/Main.css">
    <link rel="stylesheet" href="../../Assets/CSS/Stemwijzer.css">
    <script src="../../Assets/JS/Stemwijzer.js" defer></script>
    <title>Stemwijzer</title>
</head>

<body>
    <div class="QuestionWrapper">
        <p id="QuestionHeader"><?php echo $QUESTION["1"] ?></p>
        <div class="Options">
            <input id="AsSelection" type="hidden" value="<?php echo $QUESTION["2"] ?>">
            <label>
                <input name="Choice" type="radio" value="<?php echo 0 - $QUESTION["3"] ?>">Niet mee eens
            </label>
            <label>
                <input name="Choice" type="radio" value="<?php echo 0 - ($QUESTION["3"] / 2) ?>">Beetje niet mee eens
            </label>
            <label>
                <input name="Choice" type="radio" value="0">Neutraal
            </label>
            <label>
                <input name="Choice" type="radio" value="<?php echo $QUESTION["3"] / 2 ?>">Beetje mee eens
            </label>
            <label>
                <input name="Choice" type="radio" value="<?php echo $QUESTION["3"] ?>">Mee eens
            </label>
        </div>
    </div>
    <div class="NavButtons">
        <button class="BackButton" id="BackButton">Back</button>
        <button class="DissabledButtons" id="NextButton">Next</button>
    </div>
    <div class="Result">

    </div>
</body>

</html>