<?php
if(!isset($_SESSION['korisnik'])){
    header("Location: http://localhost/php2sajt1/index.php");
} else{
    $korisnikID = $_SESSION['korisnik']->korisnikID;
    $uloga = $_SESSION['korisnik']->uloga;

    $korpaObj = new Korpa(Baza::instanca());
    $korpaObj->setKorisnikID($korisnikID);
    $korpa = "";

    switch ($uloga)
    {
        case "Korisnik" : $korpa = $korpaObj->dohvatiNekupljenoKorisnik(); break;
        case "Admin" : $korpa = $korpaObj->dohvatiNekupljenoAdmin(); break;
    }
}



if(!isset($_SESSION['korisnik'])){
    header("Location: http://localhost/php2sajt1/index.php");
} else{
    $korisnikID2 = $_SESSION['korisnik']->korisnikID;
    $uloga2 = $_SESSION['korisnik']->uloga;

    $korpaObj2 = new Korpa(Baza::instanca());
    $korpaObj2->setKorisnikID($korisnikID2);
    $korpa2 = "";

    switch ($uloga2)
    {
        case "Korisnik" : $korpa2 = $korpaObj2->dohvatiKupljenoKorisnik(); break;
        case "Admin" : $korpa2 = $korpaObj2->dohvatiKupljenoAdmin(); break;
    }
}


$korisnikID3 = $_SESSION['korisnik']->korisnikID;
$korpaObj3 = new Korpa(Baza::instanca());
$korpaObj3->setKorisnikID($korisnikID2);
$suma = $korpaObj3->dohvatiSumuNekupljenihProizvoda();

?>



<div class="naslov_svaki">
    <p>U korpi :</p>
</div>


<?php if(count($korpa)): ?>
    <div id="shop_sadrzaj">
        <table class="tabela_shop">
            <tr>
                <th>SLIKA</th>
                <th>NAZIV</th>
                <th>CENA</th>
                <?php if($uloga == "Korisnik"): ?>
                    <th>IZBACI IZ KORPE</th>
                <?php endif;?>
            </tr>


            <?php foreach ($korpa as $k): ?>
                <tr>
                    <td><a href="index.php?page=product&id=<?= $k->proizvodID ?>"><img src="images/upload/<?= $k->src ?>" alt="<?= $k->alt ?>" class="malaSlika"/><a/></td>
                    <td><?= $k->proizvod ?></td>
                    <td><?= $k->cena ?> din.</td>
                    <?php if($uloga == "Korisnik"): ?>
                        <td><a href="#" data-id="<?= $k->proizvodID ?>" class="izbaciIzKorpe obrisi">Izbaci iz korpe</a></td>
                    <?php endif; ?>
                    <input type="hidden" name="idKorIzbaci" id="idKorIzbaci" value="<?= $k->korisnikID ?>"/>
                </tr>
            <?php endforeach; ?>
            <?php if($uloga == "Korisnik"): ?>
                <tr>
                    <td colspan="4">
                        <h3>Ukupno: <?= $suma->suma ?> din.</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <a href="#" data-id="<?= $k->korisnikID ?>" class="kupiDugme">KUPI</a>
                    </td>
                </tr>
            <?php endif;?>
        </table>
    </div>
<?php else: ?>
    <div class="naslov_svaki">
        <?php if($uloga == "Korisnik"): ?>
            <p>Vaša korpa je prazna</p><br/>
        <?php else: ?>
            <p>Korpa je prazna</p><br/>
        <?php endif; ?>
        <img src="images/korpa.png" alt="Prazna korpa" class="korpaS"/>
        <img src="images/korpa2.png" alt="Prazna korpa" class="korpaS"/>
        <br/><br/>
    </div>
<?php endif; ?>



<div class="naslov_svaki">
    <p>Kupljeno :</p>
</div>


<?php if(count($korpa2)): ?>
    <div id="shop_sadrzaj2">
        <table class="tabela_shop">
            <tr>
                <th>SLIKA</th>
                <th>NAZIV</th>
                <th>CENA</th>
            </tr>


            <?php foreach ($korpa2 as $k2): ?>
                <tr>
                    <td><a href="index.php?page=product&id=<?= $k2->proizvodID ?>"><img src="images/upload/<?= $k2->src ?>" alt="<?= $k2->alt ?>" class="malaSlika"/><a/></td>
                    <td><?= $k2->proizvod ?></td>
                    <td><?= $k2->cena ?> din.</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php else: ?>
    <div class="naslov_svaki">
        <?php if($uloga == "Korisnik"): ?>
            <p>Ništa niste kupili za sada</p><br/>
        <?php else: ?>
            <p>Ništa nije kupljeno za sada</p><br/>
        <?php endif; ?>
    </div>
<?php endif; ?>