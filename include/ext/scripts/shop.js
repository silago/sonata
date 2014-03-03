$(document).ready(function() {

    $('.qaptcha').QapTcha({
        autoRevert : true,
        PHPfile : '/qaptcha.php',
        txtLock: 'Сдвиньте ползунок вправо',
        txtUnlock: ''
    });

});

function registerType(param) {
    if (param == 1) {
    	$('.fiz').hide();
    	$('.org').show();
    	} else {
    		$('.fiz').show();
    		$('.org').hide();
    		}
	}


