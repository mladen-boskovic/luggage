<?php
include "functions/nav.php";
?>

<div id="beforenav">
    <div id="beforenav_drzac">
        <div>
            <?php if(isset($_SESSION['korisnik'])): ?>
                <a href="index.php?page=userprofile" title="Profil">
                    <span class="fa fa-user" aria-hidden="true"></span>
                </a>
            <?php else: ?>
                <a href="#" title="Profil" id="profilLink">
                    <span class="fa fa-user" aria-hidden="true"></span>
                </a>
            <?php endif; ?>
        </div>
        <div><a href="index.php"><img src="images/logo.png" alt="Logo" width="145px"/></a></div>
        <div>
            <?php if(isset($_SESSION['korisnik'])): ?>
                <a href="index.php?page=shop" title="Korpa">
                    <span class="fa fa-shopping-cart" aria-hidden="true"></span>
                </a>
            <?php else: ?>
                <a href="#" title="Korpa" id="korpaLink">
                    <span class="fa fa-shopping-cart" aria-hidden="true"></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="nav2">
    <div id="nav_drzac">
        <div id="nav">
            <?php nav(); ?>

        </div>
    </div>
</div>


<?php if(isset($_SESSION['korisnik'])): ?>
    <?php if($_SESSION['korisnik']->uloga == "Admin"): ?>
        <a href="index.php?page=admin" id="adminLink">Admin Panel</a>
    <?php endif; ?>
<?php endif; ?>
