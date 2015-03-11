/**
 * Fonction qui se lance au démarrage
 */
 $(document).ready(function () 
 {
	$(".button-collapse").sideNav();
	$('select').material_select();
	$('.hide').fadeOut("fast");
	$(".dropdown-button").dropdown({hover:false});
	$('.modal-trigger').leanModal();

	$(".clickable-item").click(function()
	{
		$(this).toggleClass("grey mdi-social-school");
		$(this).toggleClass("red mdi-content-clear");
	});

	(function($) {
		$.fn.spinner = function() {
			this.each(function() {
				var el = $(this);

	  // add elements
	  el.wrap('<span class="spinner"></span>');     
	  el.before('<span class="sub">-</span>');
	  el.after('<span class="add">+</span>');

	  // substract
	  el.parent().on('click', '.sub', function () {
		if (el.val() > parseInt(el.attr('min')))
			el.val( function(i, oldval) { return --oldval; });
	  });

	  // increment
	  el.parent().on('click', '.add', function () {
		if (el.val() < parseInt(el.attr('max')))
			el.val( function(i, oldval) { return ++oldval; });
	  });
	});
		};
	})(jQuery);
	$('input[type=number]').spinner();

	/**
	 * Fonction qui déplie un élément cacher
	 */
	 function deplier(el)
	 {
		el.slideToggle("slow");
	 }

	 /**
	  * Lien dépliant
	  */
	  $(".slide-link").click(function(event) {
		$elem=$(this);
		var nom =$elem.children().attr('class'); 
		if (nom=="mdi-hardware-keyboard-arrow-down") 
		{
			$elem.children().switchClass(nom,'mdi-hardware-keyboard-arrow-up')
		}
		if(nom=='mdi-hardware-keyboard-arrow-up')
		{
			$elem.children().switchClass(nom,'mdi-hardware-keyboard-arrow-down')
		}
		$hidden = $elem.parent().parent().parent().children(".hide");
		deplier($hidden);
	  });
	});
