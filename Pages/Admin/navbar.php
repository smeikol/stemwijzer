<?php
?>
<style>
    nav {
        background-color: var(--Main-color);
    }
    li {
        border: 1px solid var(--Secundair-color);
        background-color: var(--Secundair-color);
        border-radius: 5px;
        margin: 5px;
        padding: 7px;
    }
    ul {
        min-height: 25px;
        overflow: hidden;
        padding: 10px;
    }
</style>
<nav>
    <ul>
        <li style="float:left;"><a href="admin.php">Admin home</a></li>
        <li style="float:left;"><a href="vragen_crud.php">Vragen</a></li>
        <li style="float:left;"><a href="view_partijen.php">Partijen</a></li>
        <li style="float:left;"><a href="admin_crud.php">Admin accounts</a></li>
        <li style="float:right"><a href="logout.php">Uitloggen</a></li>
    </ul>
</nav>
