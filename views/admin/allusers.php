<?php
$korisnikObj = new Korisnik(Baza::instanca());
$rezultatAllUsers = $korisnikObj->dohvatiSve();


?>

<div class="naslov_svaki_admin">
    <p>Svi Korisnici</p>
</div>


<?php if(count($rezultatAllUsers)): ?>
<div id="allusers_sadrzaj">
    <table class="tabela">
        <tr>
            <th>IME</th>
            <th>PREZIME</th>
            <th>EMAIL</th>
            <th>KORISNIČKO IME</th>
            <th>ULOGA</th>
            <th>AKTIVAN</th>
            <th>IZMENI</th>
            <th>OBRIŠI</th>
        </tr>
        <?php foreach ($rezultatAllUsers as $allusers): ?>
            <tr>
                <td><?= stripslashes($allusers->ime) ?></td>
                <td><?= stripslashes($allusers->prezime) ?></td>
                <td><?= stripslashes($allusers->email) ?></td>
                <td><?= stripslashes($allusers->korisnicko_ime) ?></td>
                <td><?= $allusers->uloga ?></td>
                <td><?= $allusers->aktivan == 0 ? "Ne" : "Da"; ?></td>
                <td><a href="index.php?page=admin&adminaction=updateuser&idupdate=<?= $allusers->korisnikID ?>" class="detaljnijeD">Izmeni</a></td>
                <td><a href="#" data-id="<?= $allusers->korisnikID ?>" class="obrisiKorisnika obrisi">Obriši</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php else: ?>
    <div class="naslov_svaki_admin">
        <p>Trenutno nema korisnika</p>
    </div>
<?php endif; ?>
