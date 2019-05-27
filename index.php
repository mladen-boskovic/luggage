<?php
session_start();

function __autoload($nazivKlase)
{
    $putanja = "classes/" . $nazivKlase . ".php";
    require_once ($putanja);
}

$page = "";
if(isset($_GET['page'])){
    $page = $_GET['page'];
}

$korisnikLogovan = "";
if(isset($_SESSION['korisnik'])){
    $korisnikLogovan = $_SESSION['korisnik']->korisnikID;
}


include "views/head.php";
include "views/nav.php";
switch ($page)
{
    case "home" : include "views/home.php"; break;
    case "register" : if(isset($_SESSION['korisnik'])){
        include "views/home.php";
    } else {
        include "views/register.php";
    } break;
    case "login" : if(isset($_SESSION['korisnik'])){
        include "views/home.php";
    } else {
        include "views/login.php";
    } break;
    case "shop" : include "views/shop.php"; break;
    case "contact" : include "views/contact.php"; break;
    case "products" : include "views/products.php"; break;
    case "product" : include "views/product.php"; break;
    case "author" : include "views/author.php"; break;
    case "404" : include "views/404.php"; break;
    case "admin" : if(isset($_SESSION['korisnik'])){
        if($_SESSION['korisnik']->uloga == "Admin"){
            include "views/admin/admin.php"; break;
        } else{
            include "views/home.php"; break;
        }
    } else{
        include "views/home.php"; break;
    } break;
    case "userprofile" : include "views/userprofile.php"; break;
    case "resetpassword" : include "views/resetpassword.php"; break;
    default : include "views/home.php"; break;
}
include "views/footer.php";






