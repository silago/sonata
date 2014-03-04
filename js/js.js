


$('document').ready( function()
{
    gettotalitems();
});


function addToChart(id,q){
                var quantity = q;
                $.ajax({
                type: 'POST',
                url: '/addgood/',
                data: "id="+id+"&quantity="+quantity,
                success: function(data){
                    obj = $.parseJSON( data );
                    if (obj.error != undefined) {
                    $.createNotification({content:obj.error})
                    var html = "";
                    } 
                    else {
                    $.createNotification({content:'Товар успешно добавлен'}) } gettotal(); gettotalitems(); } });
                     
                    return false;
                    }






function gettotal(){
        }
        
function gettotalitems(){
            $.ajax({
                type: 'POST',
                url: '/totalitems/',
            
                success: function(data){
				$('.countOfItems span').html(data);
                }
            });
        return false;
        }        



function registergo(id){//alert(1);   
	$('div.err').hide();
        var ser = jQuery('form#'+id).serialize();
        $('div#error').hide();
        $('#register input[type=submit]').attr('disabled','disabled');
        jQuery.ajax({
            type: 'POST',
            url: '/registergo/',
            dataType : "json",
            data: {value:ser},                
            success: function(data){      
            
                if(data.success == false){
					
                    jQuery('div#error').html('');
                    jQuery('div#error').addClass('alert').addClass('alert-error');
                    jQuery('div#error').show();
					for (var key in data) {
									var val = data [key];
									//$('input[name='+key+']').val(val);
									$('div.err'+key).html(val);
									$('div.err'+key).show();
									//alert (key+' = '+val);
								}


                    for(i=-1;i<data.count;i++){                                             
                        var html = jQuery('div#error').html();
                        console.log(data[i]);
                        
                        
								


                        if(!(data[i] == undefined)){
                            jQuery('div#error').html(html + data[i]+'<br/>');
                        }
                      $('#register input[type=submit]').removeAttr('disabled','disabled');  
                    }

				$('#error').show();
                
                }
                else
					document.location='/';
               // alert(data);
                console.log(data.length)
                console.log(data);                  
            }
        })
        return false;
}   
