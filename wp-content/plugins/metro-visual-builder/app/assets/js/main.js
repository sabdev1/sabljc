/*---------------------------------
	Mvb row full height
----------------------------------*/
;(function($, window, undefined ) {
	'use strict';
	
	var rowFullHeightPositions = new Array();
	var prevWindowScrollTop = 0;
	var currentRow = '';
	
	var getRowFullHeightPositions = function() {
		rowFullHeightPositions = {};
		
		$('section.mvb-row-fullheight').each(function() {
			var $this = $(this);
			var id = $this.attr('id');
			var offset = $this.offset();
			
			rowFullHeightPositions[id] = {
				top: offset.top, 
				bottom: offset.top + $this.height()
			};
		});
	}
	
	var setActiveRowFullHeight = function(fullHeightNav, e) {
		var windowScrollTop = $(window).scrollTop();
		var activeRowFullHigth = null;
		
		if ($('#wpadminbar').length > 0 ) {
			windowScrollTop += $('#wpadminbar').height();
		}

		$.each(rowFullHeightPositions, function(i, val) {
			if ((val.top <= windowScrollTop) && (val.bottom > windowScrollTop)) {
				activeRowFullHigth = i;
				return false;
			}
		});

		if (activeRowFullHigth != null && $('#a-'+activeRowFullHigth).length > 0) {
			fullHeightNav.find('a').removeClass('active');
			$('#a-'+activeRowFullHigth).addClass('active');
			currentRow = activeRowFullHigth;
		}
		
		if (e != undefined) {
			if (prevWindowScrollTop < windowScrollTop) { // down
			} else { // up
				
			}
		}
		
		prevWindowScrollTop = windowScrollTop;
	}
	
	var setRowFullHeight = function() {
		var windowHeight = $(window).height();
		
		if (windowHeight != undefined) {
			
			$('section.mvb-row-fullheight').each(function() {
				var $this = $(this);
				
				$this.css({height: 'auto'});
				
				var height = ($this.height() > windowHeight) ? $this.height() : windowHeight;
				
				$this.css({
					height: height,
					'min-height': windowHeight
				});
				
			});
		}
	};
	
	var addFullHeightNav = function() {
		if (typeof($.scrollTo) != 'function') {
			return false;
		}
		
		var $fullHeightNav = $('<ul class="fullheight_nav"></ul>');
		
		$('section.mvb-row-fullheight').each(function() {
			var $this = $(this);
			var id = 'rfh-'+Math.random().toString(36).substring(7);
			$this.attr('id', id);
			
			$fullHeightNav.append('<li><a id="a-'+id+'" href="#'+id+'">&nbsp;</a></li>');
		});
		
		$('body').append($fullHeightNav);
		
		$fullHeightNav.css('margin-top', Math.round($fullHeightNav.height() / 2) * -1);
		
		getRowFullHeightPositions();
		
		setActiveRowFullHeight($fullHeightNav);
		
		$fullHeightNav.find('a').click(function() {
			var $this = $(this);
			var target_id = $(this).attr('href').replace('#', '');
			
			if (target_id != '') {
				$.scrollTo('#'+target_id, 800);
			}
			
			return false;
		});
		
		$(window).on("scroll", function(e) {
			setActiveRowFullHeight($fullHeightNav, e);
		});
	}
	
	$(document).ready(function(){
		var row_fullheight = $('.mvb_container .row-wrapper:first').hasClass('mvb-row-fullheight');
		
		if (row_fullheight) {
			$('.mvb_container .mvb-row-fullheight').addClass('mvb-row-fullheight-va');
			$('#header > .header-wrap:not(.header-hide)').addClass('header-hide');

			setRowFullHeight();
			
			addFullHeightNav();
		
			$(window).on("load resize", setRowFullHeight);
		}
	});
})(jQuery, window);
