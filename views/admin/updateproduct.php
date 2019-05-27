<?php
$brendObj = new Brend(Baza::instanca());
$rezultatBrend = $brendObj->dohvatiSve();

$kategorijaObj = new Kategorija(Baza::instanca());
$rezultatKategorija = $kategorijaObj->dohvatiSve();

$idUpdateP = $_GET['idupdate'];
$proizvodObj = new Proizvod(Baza::instanca());
$proizvodObj->setProizvodID($idUpdateP);
$rezultatProizvod = $proizvodObj->dohvatiJedan();
?>


<div class="naslov_svaki_admin">
    <p>Izmenite Proizvod</p>
</div>

<div id="register_sadrzaj">
    <div id="register_drzac">
        <form id="formaProizvod" name="formaProizvod" enctype="multipart/form-data" method="post" action="modules/admin.php">
            <table>
                <tr>
                    <td colspan="3">
                        <a href="#" data-id="<?= $rezultatProizvod->proizvodID ?>" class="obrisiProizvod obrisi">Obriši</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2"><img src="images/upload/<?= stripslashes($rezultatProizvod->src) ?>" alt="<?= stripslashes($rezultatProizvod->alt) ?>"/></td>
                    <td>
                        <p>Naziv</p>
                        <textarea id="updateProizvodNaziv" name="updateProizvodNaziv" maxlength="50"><?= stripslashes($rezultatProizvod->proizvod) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Opis</p>
                        <textarea id="updateProizvodOpis" name="updateProizvodOpis" maxlength="200"><?= stripslashes($rezultatProizvod->opis) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Slika</p>
                        <input type="file" id="insertProizvodSlika" name="insertProizvodSlika"/>
                    </td>
                    <td>
                        <p id="formaProizvodCena_t">Cena</p><br/>
                        <input type="number" id="insertProizvodCena" name="insertProizvodCena" value="<?= $rezultatProizvod->cena ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Brend</p>
                        <select id="insertProizvodBrend" name="insertProizvodBrend">
                            <option value="0">Izaberite</option>
                            <?php foreach ($rezultatBrend as $brend): ?>
                                <?php if($rezultatProizvod->brendID == $brend->brendID): ?>
                                    <option value="<?= $brend->brendID ?>" selected><?= $brend->brend ?></option>
                                <?php else: ?>
                                    <option value="<?= $brend->brendID ?>"><?= $brend->brend ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <p id="formaProizvodPol_t">Pol</p><br/>
                        <select id="insertProizvodPol" name="insertProizvodPol">
                            <?php
                                $nizOptionP = ["Izaberite"=>"0", "Muški"=>"m", "Ženski"=>"z"];
                                foreach ($nizOptionP as $in => $vr): ?>
                                    <?php if($rezultatProizvod->pol == $vr): ?>
                                    <option value="<?= $vr ?>" selected><?= $in ?></option>
                                    <?php else: ?>
                                    <option value="<?= $vr ?>"><?= $in ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <p id="formaProizvodKategorija_t">Kategorija</p><br/>
                        <select id="insertProizvodKategorija" name="insertProizvodKategorija">
                            <option value="0">Izaberite</option>
                            <?php foreach ($rezultatKategorija as $kategorija): ?>
                                <?php if($rezultatProizvod->kategorijaID == $kategorija->kategorijaID): ?>
                                    <option value="<?= $kategorija->kategorijaID ?>" selected><?= $kategorija->kategorija ?></option>
                                <?php else: ?>
                                    <option value="<?= $kategorija->kategorijaID ?>"><?= $kategorija->kategorija ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><input type="submit" value="IZMENI PROIZVOD" id="updateProductDugme" name="updateProductDugme"/></td>
                </tr>
            </table>
            <input type="hidden" value="<?= $idUpdateP ?>" name="updatePrID" id="updatePrID"/>
        </form>
    </div>
</div>

<div class="admin_greske"">

</div>