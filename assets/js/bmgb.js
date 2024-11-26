(function( $ ) {
	'use strict';
	
	var WidgetByttekMasonryGrid = function($scope, $) {
		const $filters = $scope.find('.bmgb_filters'),
			  $items = $scope.find('.bmgb_items');

		$items.isotope({
			itemSelector: '.bmgb_item',
			layoutMode: 'packery'
		});

		$filters.on('click', 'li', function () {
			var $el = $(this);

			$items.isotope({
				filter: $el.data('filter')
			});

			$el.addClass('active').siblings().removeClass('active');
		});
	};
	
	// Make sure you run this code under Elementor.
	$(window).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction('frontend/element_ready/byttek-masonry-grid.default', WidgetByttekMasonryGrid);
	} );
}(jQuery));
