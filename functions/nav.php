<?php
$navigavijaObj = new Navigacija(Baza::instanca());
function nav()
{
    global $navigavijaObj;
    function navigacija($roditelj){
        global $navigavijaObj;
        $navigavijaObj->setRoditelj($roditelj);
        $rezultatNav = $navigavijaObj->dohvatiPoRoditelju();

        if ($rezultatNav){
            echo "<ul>";
        }
        foreach($rezultatNav as $nav){
            echo "<li><a href='".$nav->href."'>".$nav->navigacija."</a>";
            navigacija($nav->navigacijaID);
            echo "</li>";
        }
        if ($rezultatNav){
            echo "</ul>";
        }
    }


    $rezultatLinkovi = $navigavijaObj->dohvatiPrviRed();

    echo "<ul id='navigacija'>";
    foreach($rezultatLinkovi as $link){
        if(isset($_SESSION['korisnik']) and ($link->navigacija == "PRIJAVI SE" or $link->navigacija == "REGISTRACIJA")){
            continue;
        }
        if(!isset($_SESSION['korisnik']) and $link->navigacija == "ODJAVI SE"){
            continue;
        }

        echo "<li><a href='".$link->href."'>".$link->navigacija."</a>";
        navigacija($link->navigacijaID);
        echo "</li>";
    }
    echo "</ul>";
}