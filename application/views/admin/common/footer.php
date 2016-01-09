</div>

<footer>
	&copy; Association Étudiante de la Faculté des Sciences de l'Université de Moncton
	<?php if(User::is_connected()): ?>
		<br />Connecté en tant que <strong><?=User::usualname()?></strong> | <a href="<?=base_url('/logout')?>">Déconnexion</a>
	<?php endif; ?>
</footer>

	
<!-- Plugins Bootstrap -->
<script type="text/javascript" src="<?=ASSETS_URL?>/bootstrap/js/bootstrap.min.js"></script>

<!-- Scripts additionnels -->
<?php if(isset($scripts) && is_array($scripts)):
	foreach ($scripts as $S): ?>
		<script type="text/javascript" src="<?=ASSETS_URL?>/javascript/<?=$S?>.js"></script>
	<?php endforeach;
endif; ?>


</body>

</html>