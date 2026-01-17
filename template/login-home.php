<section>
<h2>I miei post</h2>
<?php if(isset($templateParams["formmsg"])):?>
<p><?php echo $templateParams["formmsg"]; ?></p>
<?php endif; ?>
<a href="gestisci-articoli.php?action=1">Inserisci Articolo</a>
</section>