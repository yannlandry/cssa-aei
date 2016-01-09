var scrollamount = 10;
var current = 0;
var trigger = $('#infscr-trigger').html();

function scroll_trigger() {
	if(window.pageYOffset > $('#infscr-data').offset().top + $('#infscr-data').height() - $(window).height()) {
		load_news(); // Cette fonction va faire le reset du scroll
	}
	else {
		$(window).one('scroll', scroll_trigger); // Reset de l'événement scroll
	}
}

function load_news() {
	$('#infscr-trigger').html('<img src="' + base_url + '/assets/images/loading.gif" alt="Veuillez patienter..." />');
	current = $('#infscr-data').children().length;
	
	$.get(base_url + '/api/news?start=' + current + '&length=' + scrollamount + '&year=' + year + '&month=' + month, function(data) {
		// Traitement des données
		var end = false;
		if(data == "<END>") {
			end = true;
		}
		else {
			end = false;
			$('#infscr-data').append(data);
		}
		
		// Remise du bouton
		if(end) {
			$('#infscr-trigger').html("Aucun contenu supplémentaire à charger.");
		}
		else {
			$('#infscr-trigger').html(trigger);
			$('#infscr-trigger a').click(load_news); // Reset de l'événement click
			$(window).one('scroll', scroll_trigger); // Reset de l'événement scroll
		}
	});
	
	return false;
}

$('#infscr-trigger a').click(load_news); // Premier click
$(window).one('scroll', scroll_trigger); // Premier scroll