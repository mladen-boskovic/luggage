<?php
$slajderObj = new Slajder(Baza::instanca());
$slajder = $slajderObj->dohvatiSve();
$br = 1;
?>

<div id="slajder">
    <img src="images/slajder1.jpg" alt="Slajder1" class="trenutna"/>
    <?php foreach ($slajder as $s): ?>
        <img src="images/<?= $s->src ?>.jpg" alt="Slajder<?= ++$br ?>"/>
    <?php endforeach; ?>
</div>

<div id="pogodnosti">
    <div id="pogodnosti_drzac">
        <table>
            <tr>
                <td>
                    <a>
                        <span class="fa fa-truck" aria-hidden="true"></span>
                    </a>
                </td>
                <td>
                    <p class="pogodnosti_naslov">BESPLATNA DOSTAVA</p>
                </td>
                <td>
                    <a>
                        <span class="fa fa-rotate-right" aria-hidden="true"></span>
                    </a>
                </td>
                <td>
                    <p class="pogodnosti_naslov">BESPLATNA ZAMENA</p>
                </td>
                <td>
                    <a>
                        <span class="fa fa-question-circle" aria-hidden="true"></span>
                    </a>
                </td>
                <td>
                    <p class="pogodnosti_naslov">PODRŠKA MUŠTERIJAMA</p>
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td>
                    <p class="pogodnosti_tekst">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.
                    </p>
                </td>
                <td>

                </td>
                <td>
                    <p class="pogodnosti_tekst">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.
                    </p>
                </td>
                <td>

                </td>
                <td>
                    <p class="pogodnosti_tekst">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="naslov_svaki">
    <p>Najprodavaniji Proizvodi</p>
</div>


<?php
$proizvodObj = new Proizvod(Baza::instanca());
$rezultatProizvodi = $proizvodObj->dohvatiCetiriNajprodavanijaProizvoda();
?>
<div id="proizvodi_home">
    <div id="proizvodi_drzac_home">
        <?php foreach ($rezultatProizvodi as $proizvod): ?>
            <div class="proizvod">
                <img src="images/upload/<?= stripslashes($proizvod->src) ?>" alt="<?= stripslashes($proizvod->alt) ?>"/>
                <div class="detaljnije2">
                    <p class="ps_naziv"><?= stripslashes($proizvod->proizvod) ?></p>
                    <p class="ps_cena"><?= $proizvod->cena ?> din.</p>
                    <a href="index.php?page=product&id=<?= $proizvod->proizvodID ?>" class="detaljnije">DETALJNIJE</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>