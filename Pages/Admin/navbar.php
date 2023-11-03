<?php
?>
<style>
    nav {
        padding-top: 20px;
    }
    li {
        border: 1px solid black;
        margin: 5px;
        padding: 5px;
        transition: 200ms;
    }
    li:hover {
        background-color: var(--Secundair-color);
    }
    ul {
        min-height: 25px;
        overflow: hidden;
    }
</style>
<nav>
    <ul>
        <li style="float:left;"><a href="vragen_crud.php">Vragen</a></li>
        <li style="float:left;"><a href="view_partijen.php">Partijen</a></li>
        <li style="float:right"><a href="logout.php">Uitloggen</a></li>
    </ul>
</nav>
