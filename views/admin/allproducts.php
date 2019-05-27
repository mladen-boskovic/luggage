<?php
$proizvodObj = new Proizvod(Baza::instanca());
$rezultatAllProducts = $proizvodObj->dohvatiSve();

?>

<div class="naslov_svaki_admin">
    <p>Svi Proizvodi</p>
</div>

<?php if(count($rezultatAllProducts)): ?>
<div id="allproducts_sadrzaj">
    <table class="tabela">
        <tr>
            <th>SLIKA</th>
            <th>NAZIV</th>
            <th>OPIS</th>
            <th>CENA</th>
            <th>POL</th>
            <th>BREND</th>
            <th>KATEGORIJA</th>
            <th>IZMENI</th>
            <th>OBRIŠI</th>
        </tr>
        <?php foreach ($rezultatAllProducts as $allproducts): ?>
            <tr>
                <td><a href="index.php?page=product&id=<?= $allproducts->proizvodID ?>"><img src="images/upload/<?= stripslashes($allproducts->src) ?>" alt="<?= stripslashes($allproducts->alt) ?>" class="malaSlika"/></a></td>
                <td><?= stripslashes($allproducts->proizvod) ?></td>
                <td><?= stripslashes($allproducts->opis) ?></td>
                <td><?= $allproducts->cena ?> din.</td>
                <td><?= $allproducts->pol == 'm' ? "Muški" : 'Ženski'; ?></td>
                <td><?= $allproducts->brend ?></td>
                <td><?= $allproducts->kategorija ?></td>
                <td><a href="index.php?page=admin&adminaction=updateproduct&idupdate=<?= $allproducts->proizvodID ?>" class="detaljnijeD">Izmeni</a></td>
                <td><a href="#" data-id="<?= $allproducts->proizvodID ?>" class="obrisiProizvod obrisi">Obriši</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php else: ?>
    <div class="naslov_svaki_admin">
        <p>Trenutno nema proizvoda</p>
    </div>
<?php endif; ?>
