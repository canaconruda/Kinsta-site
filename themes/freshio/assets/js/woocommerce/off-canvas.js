(function ($) {
    'use strict';

    $(function () {
        var $body = $('body');
        $body.on('click', '.filter-toggle', function (e) {
            e.preventDefault();
            $('html').toggleClass('off-canvas-active');
        });

        $body.on('click', '.filter-close, .freshio-overlay-filter', function (e) {
            e.preventDefault();
            $('html').toggleClass('off-canvas-active');
        });

        // Dropdown
		var $dropdownWrapper = $('body .freshio-dropdown-filter');

		$body.on('click','.filter-toggle-dropdown',function (e) {
			e.preventDefault();
			$dropdownWrapper.toggleClass('active-dropdown').slideToggle();
		});
    });


})(jQuery);
