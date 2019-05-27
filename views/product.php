<?php
$proizvod = null;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $proizvodObj = new Proizvod(Baza::instanca());
    $proizvodObj->setProizvodID($id);
    $proizvod = $proizvodObj->dohvatiJedan();
    if(!$proizvod){
        header("Location: http://localhost/php2sajt1/index.php");
    }

} else{
    header("Location: http://localhost/php2sajt1/index.php");
}
?>

<div id="product_sadrzaj">
    <div id="product_drzac">
        <a href="images/upload/<?= stripslashes($proizvod->src) ?>" class="vecaSlika"><img src="images/upload/<?= stripslashes($proizvod->src) ?>" alt="<?= stripslashes($proizvod->alt) ?>"/></a>
        <div id="o_proizvodu">
            <p id="p_naziv"><?= stripslashes($proizvod->proizvod) ?></p>
            <p id="p_opis"><?= stripslashes($proizvod->opis) ?></p>
            <p id="p_dodatno"><?php echo $proizvod->pol=="m" ? "Muški" : "Ženski"; ?> <?= $proizvod->kategorija ?> &nbsp;-&nbsp;  <?= $proizvod->brend ?></p>
            <p id="p_cena"><?= $proizvod->cena ?> din.</p>
            <?php if(isset($_SESSION['korisnik'])):
                if($_SESSION['korisnik']->uloga == "Admin"): ?>
                    <a href="index.php?page=admin&adminaction=updateproduct&idupdate=<?= $proizvod->proizvodID ?>" class="p_opcije">IZMENI PROIZVOD</a>
                <?php else: ?>
                    <a href="#" data-id="<?= $proizvod->proizvodID ?>" class="p_opcije dodaj">DODAJ U KORPU</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="#" data-id="<?= $proizvod->proizvodID ?>" class="p_opcije dodaj">DODAJ U KORPU</a>
            <?php endif; ?>
            <input type="hidden" id="sessionIdKor" name="sessionIdKor" value="<?= $korisnikLogovan ?>"/>
        </div>
    </div>
</div>