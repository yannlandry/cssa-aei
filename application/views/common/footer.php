<footer>
	<p>&copy; Association Étudiante de la Faculté des Sciences de l'Université de Moncton<br />
		<a href="https://www.facebook.com/pages/AEFSUM/37629527089" target="_blank" title="Suivez-nous sur Facebook"><img src="<?=ASSETS_URL?>/images/facebook.png" /></a>
		<a href="https://www.twitter.com/AEFSUM" target="_blank" title="Suivez-nous sur Twitter"><img src="<?=ASSETS_URL?>/images/twitter.png" /></a>
	</p>
	
	<p>
		<?php if(User::is_connected()): ?>
			<em>Connecté en tant que <strong><?=User::usualname()?></strong></em><br />
		<?php endif; ?>
		<a href="<?=base_url('/admin')?>">Administration</a>
		<?php if(User::is_connected()): ?> | <a href="<?=base_url('/logout')?>">Déconnexion</a><?php endif; ?>
	</p>
</footer>


<!-- jQuery -->
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script> La v1.10 ne fonctionne pas avec TinyMCE-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	
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