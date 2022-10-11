<?php
    session_start();
    if(!isset($_SESSION['id_usuario']))
    {
        header("location: index.php");
        exit;
    }
?>

<h1> Aqui será a página com os shows de stand - up! (em construção) </h1>