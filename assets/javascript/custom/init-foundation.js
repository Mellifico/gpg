jQuery(document).foundation();

jQuery(document).ready(function($) {  

// site preloader -- also uncomment the div in the header and the css style for #preloader
$(window).load(function(){
	$('#preloader').fadeOut('slow',function(){$(this).remove();});
	$('#brand-motion').addClass('is-animating');
	$('#seal-motion').addClass('is-animating');
	
});
$('.img-link').magnificPopup({type:'image', closeOnContentClick:true});

var $items = $('#grid-isotope-items').isotope({
    itemSelector: '.item'
});
// layout Isotope after each image loads
$items.imagesLoaded().progress( function() {
  $items.isotope('layout');
});
var $seals = $('#grid-isotope-seals').isotope({
    itemSelector: '.seal',
    stamp: '.stamp'
});
// layout Isotope after each image loads
$seals.imagesLoaded().progress( function() {
  $seals.isotope('layout');
});
});
