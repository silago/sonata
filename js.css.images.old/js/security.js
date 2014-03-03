$(document).ready(function() {
    
    // Получение состояния авторизации
    $.post (
    "/getstate",
    {
        modCall: 1
    },
    onGetState
    );
    
    function onGetState (data) {
        if ($('.secForm').length) {
            $('.secForm').html (data);
        }
    }
});

function registergo(id){
		var ser = jQuery('form#'+id).serialize();
		jQuery.ajax({
			type: 'POST',
			url: '/registergo/',
			dataType : "json",
			data: {value:ser},                
			success: function(data){				
				if(data.success == false){
					jQuery('div#error').html('');
					jQuery('div#error').addClass('alert').addClass('alert-error');
					
					for(i=-1;i<data.count;i++){												
						var html = jQuery('div#error').html();
						console.log(data[i]);
						
						if(!(data[i] == undefined)){
							jQuery('div#error').html(html + data[i]+'<br/>');
						}
						
					}
				
				}
				
				console.log(data.length)
				console.log(data);					
            }
        })
        return false;
}	