<?php
$kategorija = "";
if(isset($_GET['category'])){
    $kategorija = $_GET['category'];
}

$kategorijaObj = new Kategorija(Baza::instanca());
$rezultatKategorija = $kategorijaObj->dohvatiSve();

$brendObj = new Brend(Baza::instanca());
$rezultatBrend = $brendObj->dohvatiSve();

$proizvodObj = new Proizvod(Baza::instanca());
$rezultatProizvodi = $proizvodObj->dohvatiSve();





$str = "1";
if(isset($_GET['str'])){
    $str = $_GET['str'];
}

?>

<input type="hidden" value="<?= $str ?>" id="kojaStranica" name="kojaStranica"/>








<div class="naslov_svaki">
    <p>Svi Proizvodi</p>
</div>

<div class="stranice">
</div>

<div id="proizvodi_products">
    <div id="proizvodi_drzac">
        <div id="proizvodi_filter">
            <h3>Filtriranje i sortiranje</h3>
            <div id="sortirajDiv">
                <p>Sortiraj :</p>
                <select id="sortiraj">
                    <option value="0">Izaberite</option>
                    <option value="1">Cena rastuća</option>
                    <option value="2">Cena opadajuća</option>
                    <option value="3">Naziv A-Z</option>
                    <option value="4">Naziv Z-A</option>
                </select>
            </div>
            <div>
                <p>Kategorija :</p>
                <?php foreach ($rezultatKategorija as $kat): ?>
                    <?php if(($kategorija) && ($kategorija == strtolower($kat->kategorija))): ?>
                        <input type="checkbox" name="kategorija_filter" class="kategorija_filter" value="<?= $kat->kategorijaID ?>" checked/> <?= $kat->kategorija ?> <br/>
                    <?php else: ?>
                        <input type="checkbox" name="kategorija_filter" class="kategorija_filter" value="<?= $kat->kategorijaID ?>"/> <?= $kat->kategorija ?> <br/>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div>
                <p>Brend :</p>
                <?php foreach ($rezultatBrend as $brend): ?>
                    <input type="checkbox" name="brend_filter" class="brend_filter" value="<?= $brend->brendID ?>"/> <?= $brend->brend ?> <br/>
                <?php endforeach; ?>
            </div>

            <div>
                <p>Pol :</p>
                <input type="checkbox" name="pol_filter" value="m" class="pol_filter"/> Muški <br/>
                <input type="checkbox" name="pol_filter" value="z" class="pol_filter"/> Ženski <br/>
            </div>

            <div>
                <p>Cena :</p>
                <input type="number" id="minCena" name="minCena" placeholder="Cena od" class="inputCenaFilter"/> <br/>
                <input type="number" id="maxCena" name="maxCena" placeholder="Cena do" class="inputCenaFilter"/> <br/>
            </div>

            <div>
                <p>Poništavanje svega :</p>
                <input type="button" id="ponistiSve" name="ponistiSve" value="Poništi sve" class=""/>
            </div>


        </div>


        <div id="proizvodi_sadrzaj">
        </div>

    </div>
</div>

<div class="stranice">
</div>

<div class="ucitavanje">
</div>