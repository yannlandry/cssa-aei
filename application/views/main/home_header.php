<body>


<header>

	<!-- Navbar -->
	<div class="navbar-container">
		<div class="container">
			<div class="navbar navbar-inverse">
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
		</div>
	</div>
	
	
	<!-- Carousel -->
	<div class="container">
		<div id="home-carousel" class="carousel slide">
			<ol class="carousel-indicators hidden-xs">
				<?php for($i = 0; $i < count($pictures); ++$i): ?>
					<li data-target="#home-carousel" data-slide-to="<?=$i?>"<?php $i == 0 and print(' class="active"'); ?>></li>
				<?php endfor; ?>
			</ol>
			
			<div class="carousel-inner">
				<?php for($i = 0; $i < count($pictures); ++$i): ?>
					<div class="item<?php $i == 0 and print(' active'); ?>">
						<img src="<?=$pictures[$i]?>" alt="<?=$i?>" class="img-responsive" />
					</div>
				<?php endfor; ?>
			</div>
			
			<a class="left carousel-control hidden-xs" href="#home-carousel" data-slide="prev">
				<span class="icon-prev"></span>
			</a>
			<a class="right carousel-control hidden-xs" href="#home-carousel" data-slide="next">
				<span class="icon-next"></span>
			</a>
		</div>
	</div>

</header>

<div class="container">
	<?php # Lecture des messages flash
		readFlash(); ?>
</div>