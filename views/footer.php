<?php
$footerObj = new Footer(Baza::instanca());
$rezultatFooter = $footerObj->dohvatiSve();
?>

<div id="footer">
    <ul>
        <?php foreach ($rezultatFooter as $footer): ?>
            <?php if($footer->href == "index.php?page=author"): ?>
            <li><a href="<?= $footer->href ?>"><span class="<?= $footer->class ?>" aria-hidden="true"></span></a></li>
            <?php else: ?>
            <li><a href="<?= $footer->href ?>" target="_blank"><span class="<?= $footer->class ?>" aria-hidden="true"></span></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

    <p>Copyright &copy; Luggage</p>
</div>

<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/simpleLightbox.min.js"></script>
</body>
</html>