<?php
session_start();
if(isset($_SESSION['korisnik'])){
    unset($_SESSION['korisnik']);
    session_destroy();
    header("Location: http://localhost/php2sajt1/index.php");
} else{
    header("Location: http://localhost/php2sajt1/index.php");
}