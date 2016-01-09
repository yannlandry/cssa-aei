<body>


<header>

	<div class="navbar navbar-inverse navbar-static-top">
		<div class="container">
		
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=base_url()?>"><img src="<?=ASSETS_URL?>/images/logo.png" alt="AEFSUM" /></a>
			</div>
			
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<?php $menuItems = menu_items();
					foreach($menuItems as $I): ?>
						<li><a href="<?=(substr($I->Link,0,4)=='http'?$I->Link:base_url($I->Link))?>"><?=$I->Text?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		
		</div>
	</div>
	
	<?php if(!empty($headerTitle) || !empty($headerParagraph)): ?>
		<div id="pageHeader">
			<div class="container">
				<?php if(!empty($headerTitle)): ?><h1><?=$headerTitle?></h1><?php endif; ?>
				<?php if(!empty($headerParagraph)): ?><p><?=$headerParagraph?></p><?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

</header>

<div class="container">
	<?php # Lecture des messages flash
		readFlash(); ?>
</div>