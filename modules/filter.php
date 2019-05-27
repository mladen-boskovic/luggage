<?php
require_once "../classes/SuperKlasa.php";
require_once "../classes/Proizvod.php";
require_once "../classes/Baza.php";

if(isset($_POST['filterDugme']))
{
    header("Content-Type: application/json");
    $data = null;

    $sortiraj = $_POST['sortiraj'];
    $kategorijeStr = $_POST['kategorijeStr'];
    $brendoviStr = $_POST['brendoviStr'];
    $poloviStr = $_POST['poloviStr'];
    $minCena = $_POST['minCena'];
    $maxCena = $_POST['maxCena'];

    $nizPodaci = [];
    if($kategorijeStr)
        $nizPodaci['kategorijaID'] = $kategorijeStr;
    if($brendoviStr)
        $nizPodaci['brendID'] = $brendoviStr;
    if($poloviStr)
        $nizPodaci['pol'] = $poloviStr;
    if($minCena)
        $nizPodaci['minCena'] = $minCena;
    if($maxCena)
        $nizPodaci['maxCena'] = $maxCena;

    $upit = "SELECT * FROM proizvod p INNER JOIN kategorija k ON p.kategorijaID = k.kategorijaID
             INNER JOIN brend b ON p.brendID = b.brendID";


    $nizDeloviUpita = [];
    if(count($nizPodaci))
    {
        foreach($nizPodaci as $in => $vr)
        {
            if($in == "minCena")
            {
                $nizDeloviUpita[] = "p.cena >= " . $vr;
            }
            else if($in == "maxCena")
            {
                $nizDeloviUpita[] = "p.cena <= " . $vr;
            }
            else
            {
                $nizDeloviUpita[] = "p." . $in . " IN " . "(" . $vr .")";
            }
        }
    }

    $podaciStr = "";

    if(count($nizDeloviUpita))
        $podaciStr = implode(" AND ", $nizDeloviUpita);

    if($podaciStr)
        $upit = $upit . " WHERE ";

    $upit = $upit . $podaciStr;

    $dodatakSortiranje = "";
    if($sortiraj != 0)
    {
        if($sortiraj == 1)
        {
            $dodatakSortiranje = " ORDER BY p.cena ASC";
        }
        else if($sortiraj == 2)
        {
            $dodatakSortiranje = " ORDER BY p.cena DESC";
        }
        else if($sortiraj == 3)
        {
            $dodatakSortiranje = " ORDER BY p.proizvod ASC";
        }
        else
        {
            $dodatakSortiranje = " ORDER BY p.proizvod DESC";
        }
    }

    $upit = $upit . $dodatakSortiranje;


    $proizvod = new Proizvod(Baza::instanca());
    $data = $proizvod->filter($upit);
    if(!$data){
        $data = null;
    }


    echo json_encode(['message' => $data]);
} else{
    header("Location: http://localhost/php2sajt1/index.php");
}