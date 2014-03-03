

jQuery(document).ready(function(){



    var params = {
        changedEl: ".lineForm select",
        visRows: 10,
        scrollArrows: false
    }

    cuSel(params);
	
    if ($("#ex-one").length) $("#ex-one").organicTabs();
	
	

	
});
$(window).load(function() {
	$('.sliderImage').show();
	if ($('.flexslider').length) $('.flexslider').flexslider();
});

(function($) {
    $(function() {

        $('input.styledRadio').radio();

        $('#add').click(function() {
            var inputs = '';
            for (i = 1; i <= 5; i++) {
                inputs += '<br /><label><input type="radio" name="radio" class="styledRadio" /> radio ' + i + '</label>';
            }
            $('form').append(inputs);
            $('input.styled').radio();
            return false;
        })

        $('#toggle').click(function() {
            (function($) {
                $.fn.toggleDisabled = function() {
                    return this.each(function() {
                        this.disabled = !this.disabled;
                    });
                };
            })(jQuery);
            $('input.styledRadio').toggleDisabled().trigger('refresh');
            return false;
        })

    })
})(jQuery)






