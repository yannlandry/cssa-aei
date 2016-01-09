<!DOCTYPE html>
<html>

<head>

	<title><?=(!empty($pageTitle)?$pageTitle:"Administration")?></title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_URL?>/bootstrap/css/bootstrap_admin.css" />
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_URL?>/style/admin.css" />
	
	<!-- jQuery -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

</head>

<body>


<header>

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
		
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=base_url('/admin')?>">Administration</a>
			</div>
			
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="<?=base_url('/admin/nouvelles')?>">Nouvelles</a></li>
					<?php if(User::is_admin()): ?>
						<?php $newmsgs = count_new_messages(); ?>
						<li><a href="<?=base_url('/admin/pages')?>">Pages</a></li>
						<li><a href="<?=base_url('/admin/menu')?>">Menu</a></li>
						<li><a href="<?=base_url('/admin/diaporama')?>">Diaporama</a></li>
						<li><a href="<?=base_url('/admin/messages')?>">Messages<?php $newmsgs > 0 and print(' <span class="badge">'.$newmsgs.'</span>'); ?></a></li>
						<li><a href="<?=base_url('/admin/comptes')?>">Comptes</a></li>
						<li><a href="<?=base_url('/admin/fichiers')?>">Fichiers</a></li>
					<?php endif; ?>
					<li><a href="<?=base_url('/admin/images')?>">Images</a></li>
					<li><a href="<?=base_url('/admin/moncompte')?>">Mon compte</a></li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li><a href="<?=base_url()?>" target="_blank">AEFSUM.ca</a></li>
				</ul>
			</div>
		
		</div>
	</div>

</header>


<div class="container">

	<div class="page-header">
		<h1><?php !empty($headerTitle) and print($headerTitle); !empty($headerSmall) and print(' <small>'.$headerSmall.'</small>'); ?></h1>
		<?php !empty($headerParagraph) and print('<p>'.$headerParagraph.'</p>'); ?>
	</div>
	
	<?php # Lecture des messages flash
		readFlash(); ?>