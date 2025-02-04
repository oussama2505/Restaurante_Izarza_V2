(function( $ ) {
 
    "use strict";
     
    //repeatable main method
	$('.narep-extend-fields-wrap').each(function() {
		$(this).repeatable_fields({
			wrapper: '.widget-wrapper',
            container: '.widget-container',
            row: '.widget-row',
            add: '.narep-extend-fields-add',
            remove: '.narep-extend-fields-remove',
            move: '.narep-extend-fields-move',
            template: '.template',
            is_sortable: true
		});
	});

	//toggle repeated fields
	$(document).on('click', '.narep-extend-field-action', function(e){
		e.preventDefault();
		$(this).parents('.widget').toggleClass('close open').find('.widget-inside').slideToggle('fast');
	});

	//Action buttons of repeated fields
	$(document).on('click', '.narep-extend-fields-remove', function(e){ e.preventDefault(); });
	$('.narep-extend-fields-add').on('click', function(e){ e.preventDefault(); });

	$(document).on('keyup contextmenu input', '.narep-extend-title', function(){
		var $this = $(this);
		$this.parents('.widget').find('.widget-title h3').text($this.val());
	});

	$(document).on('keyup contextmenu input', 'input.wc_input_price', function(){
		var $this = $(this);
		var $price = $this.val();
		$('input.wc_input_price_for_gift').attr('value', $price);
	});

    function rctl_bw_form_submit(){
        $('.rcafe-bw-settings-form').submit( function(e) {
            e.preventDefault();
            let targetForm      	= $(this);
            let targetFormArray 	= targetForm.serializeArray();
            let targetFormajaxURL 	= targetForm.attr('data-ajax-url');
            let targetFormNonce     = targetForm.attr('data-nonce');
            
            $.ajax({
                type: 'POST',
                url: targetFormajaxURL,
                data: {
                	'action': 'rcafe_bw_settings_save',
                	'data' : targetFormArray,
                    'nonce' : targetFormNonce
                },
				beforeSend: function() {
				    $('.rcafe-bw-settings-save').text('Saving...');
				},
                success: function (resultString) {
                	$('.rcafe-bw-settings-save').text('Saved!');
                },
                complete: function () {
                	setTimeout( function() {
                		$('.rcafe-bw-settings-save').text('Save');
                	}, 1000);
                },           
                error: function () {
                	
                }            
            });        
        }); 
    }
	rctl_bw_form_submit();

    function rctl_bw_toggle_submit(toggle, toggleVal){
        let targetFormajaxURL 	= toggle.attr('data-ajax-url');
        let targetFormNonce     = toggle.attr('data-nonce');
        
        $.ajax({
            type: 'POST',
            url: targetFormajaxURL,
            data: {
            	'action': 'rctl_bw_toggle_submit',
            	'data' : toggleVal,
                'nonce' : targetFormNonce
            },
            success: function (resultString) {
            	// $('.rcafe-bw-settings-form').submit();
            },
            complete: function () {

            },           
            error: function () {
            	
            }            
        });
    }

	function rctl_bw_toggle_trigger(toggle){
		setTimeout(function(){
			if ($('#narep-checkbox-toggle-bw').is(':checked')) {
				$('.rcafe-bw-settings-form input[type="checkbox"]').each(function(){
					$(this).prop('checked', true);
				});
			} else {
				$('.rcafe-bw-settings-form input[type="checkbox"]').each(function(){
					$(this).prop('checked', false);
				});
			}
		}, 100);
	}

	$('.narep-checkbox-toggle-bw-slider').on('click', function(e) {
		rctl_bw_toggle_trigger($(this));
	});

	$('.rcafe-bw-settings-save').on('click', function(e) {
		$('.rcafe-bw-settings-form').submit();
		setTimeout(function(){
			if ($('#narep-checkbox-toggle-bw').is(':checked')) {
				rctl_bw_toggle_submit($('.narep-checkbox-toggle-bw-slider'), 1);
			} else {
				rctl_bw_toggle_submit($('.narep-checkbox-toggle-bw-slider'), 0);
			}
		}, 100);		
	});	

	// Unique settings
    function rctl_uw_form_submit(){
        $('.rcafe-uw-settings-form').submit( function(e) {
            e.preventDefault();
            let targetForm      	= $(this);
            let targetFormArray 	= targetForm.serializeArray();
            let targetFormajaxURL 	= targetForm.attr('data-ajax-url');
            let targetFormNonce     = targetForm.attr('data-nonce');
            
            $.ajax({
                type: 'POST',
                url: targetFormajaxURL,
                data: {
                	'action': 'rcafe_uw_settings_save',
                	'data' : targetFormArray,
                    'nonce' : targetFormNonce
                },
				beforeSend: function() {
				    $('.rcafe-uw-settings-save').text('Saving...');
				},
                success: function (resultString) {
                	$('.rcafe-uw-settings-save').text('Saved!');
                },
                complete: function () {
                	setTimeout( function() {
                		$('.rcafe-uw-settings-save').text('Save');
                	}, 1000);
                },           
                error: function () {
                	
                }            
            });        
        }); 
    }
	rctl_uw_form_submit();

    function rctl_uw_toggle_submit(toggle, toggleVal) {
        let targetFormajaxURL 	= toggle.attr('data-ajax-url');
        let targetFormNonce     = toggle.attr('data-nonce');
        
        $.ajax({
            type: 'POST',
            url: targetFormajaxURL,
            data: {
            	'action': 'rctl_uw_toggle_submit',
            	'data' : toggleVal,
                'nonce' : targetFormNonce
            },
            success: function (resultString) {
            	// $('.rcafe-uw-settings-form').submit();
            },
            complete: function () {

            },           
            error: function () {
            	
            }            
        });
    }

	function rctl_uw_toggle_trigger( toggle ){
		setTimeout( function() {
			if ($('#narep-checkbox-toggle-uw').is(':checked')) {
				$('.rcafe-uw-settings-form input[type="checkbox"]').each(function(){
					$(this).prop('checked', true);
				});
			} else {
				$('.rcafe-uw-settings-form input[type="checkbox"]').each(function(){
					$(this).prop('checked', false);
				});
			}
		}, 100);
	}

	$('.narep-checkbox-toggle-uw-slider').on('click', function(e) {
		rctl_uw_toggle_trigger( $(this) );
	});

	$('.rcafe-uw-settings-save').on('click', function(e) {
		$('.rcafe-uw-settings-form').submit();
		setTimeout(function(){
			if ($('#narep-checkbox-toggle-uw').is(':checked')) {
				rctl_uw_toggle_submit($('.narep-checkbox-toggle-uw-slider'), 1);
			} else {
				rctl_uw_toggle_submit($('.narep-checkbox-toggle-uw-slider'), 0);
			}
		}, 100);			
	});	

	// Search filter
	$(".narep-search-widget-field").on('keyup', function() {
	    var search = $(this).val().toLowerCase();
		$(".narep-widget-col").show().filter(function() {
			return $(this).attr('data-widget-name').toLowerCase().indexOf(search) == -1;
		}).hide();

		if(search.length > 0) {
			$('.narep-checkbox-toggle-text, .narep-checkbox-toggle-label').hide();
		} else {
			$('.narep-checkbox-toggle-text, .narep-checkbox-toggle-label').show();
		}
	});	
 
})(jQuery);