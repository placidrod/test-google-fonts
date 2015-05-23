(function($){

	/* Load fonts at document ready
	===================================== */

	$(document).ready(function(){
		$.get('serve_json.php', { saveFontFile: 1 });		
	});

	/* Change Category
	===================================== */

	$('#font-category').on('change', function(){
		var category = $(this).val();
		$('#font-family, #font-variant').html('');
		$.get('serve_json.php', { category: category }, function(response){
			$('#font-family').append(response);
		});
	});

	/* Change Font Family
	===================================== */

	$('#font-family').on('change', function(){
		var family = $(this).val();
		var applicableFont = family.replace(/ /, '+');
		var userText = $('#user-text').val();
		if(userText != '') {
			var existingFont = $('link[href^="http"]');
			existingFont.remove();
			var link = '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=';
			link += applicableFont;
			link += '">';
			$('head').append(link);
			$('#user-text').css('font-family', family);

			$('#font-variant').html('');

			$.get('serve_json.php', { familyForVariant: family }, function(response){
				$('#font-variant').append(response);
				// console.log(response);
			});

			$.get('serve_json.php', { familyForCategory: family }, function(response) {
				$('#font-category-hidden').val(response);
			});
		} else {
			alert("Write Your Text first !!!");
		}
	});

	/* Change Font Variant
	===================================== */	

	$("#font-variant").on('change', function(){
		var variant = $(this).val();
		var family = $('#font-family').val();

		var applicableFont = family.replace(/ /, '+');
		applicableFont += ':' + variant;

		if(family != '') {
			var existingFont = $('link[href^="http"]');
			existingFont.remove();
			var link = '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=';
			link += applicableFont;
			link += '">';
			$('head').append(link);
			var fontDesign = {'font-family': family};			
			$('#user-text').css(fontDesign);
			if(/italic/.test(variant)) {
				//fontDesign['font-style'] = 'italic';
				$('#user-text').addClass('italic');
			} else {
				$('#user-text').removeClass('italic');
			}
		} else {
			alert("Select Font First!");
		}
	});


	/* Color Picker
	==================================== */

	$("#color-picker").spectrum({
	    color: "#555",
	    showInput: true,
	    className: "full-spectrum",
	    showInitial: true,
	    showPalette: true,
	    showSelectionPalette: true,
	    maxSelectionSize: 10,
	    preferredFormat: "hex",
	    localStorageKey: "spectrum.demo",
	    move: function (color) {
	        $('#user-text').css('color', color);
	    },
	    show: function () {
	    
	    },
	    beforeShow: function () {
	    
	    },
	    hide: function () {
	    
	    },
	    change: function(color) {
	        $('#user-text').css('color', color);
	    },
	    palette: [
	        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
	        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
	        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
	        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
	        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
	        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
	        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
	        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
	        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
	        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
	        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
	        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
	        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
	        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
	    ]
	});

	/* Font sizing
	===================================== */

	$('#font-size').on('change', function(){
		var newSize = $(this).val() + 'px';
		$('#user-text').css('font-size', newSize);
	});

	/* Show Code
	===================================== */

	$('#font-form').on('submit', function (event) {

		event.preventDefault();
		$('#output-html, #output-css').html('');
		var existingFont = $('link[href^="http"]');
		if(existingFont.length == 0) {
			alert("Select a font family !!!");
			return false;
		}

		var htmlLink = existingFont[0].outerHTML;
		var htmlOutput = htmlLink.replace('<', '&lt');
		$('#output-html').html(htmlOutput);

		var fontFamily = $('#user-text').css('font-family');

		var fontCategory = $("#font-category-hidden").val();

		var fontCategoryCss;

		switch (fontCategory) {
			case 'serif':
				fontCategoryCss = 'serif';
				break;
			case 'sans-serif':
				fontCategoryCss = 'sans-serif';
				break;
			case 'display':
				fontCategoryCss = 'cursive';
				break;
			case 'handwriting':
				fontCategoryCss = 'cursive';
				break;
			case 'monospace':
				fontCategoryCss = '';
				break;
		}

		var fontColor = $('#user-text').css('color');
		var fontSize = $('#user-text').css('font-size');
		var fontStyle = $('#user-text').css('font-style');

		var cssOutput = 'sample-element { ';
		cssOutput += 'font-family: ' + fontFamily + '; ';
		cssOutput += 'color: ' + fontColor + '; ';
		cssOutput += 'font-size: ' + fontSize + '; ';
		cssOutput += 'font-style: ' + fontStyle + '; ';
		cssOutput += '}';
		$('#output-css').html(cssOutput);

		$('.output-div').show();
	});

	/* Further Styling
	===================================== */
	
	var hideElements = function() {
		if($('.header').css('opacity') != 0) {
			$('.header').animate({
				opacity: 0
			}, 500);
		}
	}

	$('#user-text, #font-category, #font-family').on('focus', hideElements);

})(jQuery);