<!DOCTYPE html>
<html>


<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Titre de page -->
<title><?=(isset($pageTitle) ? $pageTitle : "Association Étudiante de la Faculté des Sciences de l'Université de Moncton")?></title>

<!-- Styles -->
<link href="http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic&subset=latin,latin-ext" rel="stylesheet" type="text/css" />
<link href="<?=ASSETS_URL?>/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?=ASSETS_URL?>/style/aefsum.css" rel="stylesheet" type="text/css" />

<!-- Styles additionnels -->
<?php if(isset($styles) && is_array($styles)):
	foreach($styles as $S): ?>
		<link href="<?=ASSETS_URL?>/style/<?=$S?>.css" rel="stylesheet" type="text/css" />
<?php endforeach;
endif; ?>

</head>