<?php

if (!isset($_SESSION["id"])){
    header('Location: index.php?Log');
} else {
    $login = $_SESSION['login'];
}
