


$('document').ready( function()
{
    gettotalitems();
});


function deleteFromCart(id) {
            if (confirm('удалить элемент?')) {
                jQuery.ajax({
                    type: 'POST',
                    url: '/delformcart/',
                    dataType: 'json',
                    data: {id: id},
                    success: function(data) {
                        if (data.amount > 0) {
                            jQuery('.upBasket').find('b').html(data.amount);
                        } else {
                        document.location='/';
                        }
						$('.q-'+id).closest('tr').hide(300);
						//console.log(id);
						$.createNotification({content:'позиция удалена'})
						
						gettotal();
						gettotalitems();
                      //  jQuery('div#basket').empty();
                     //   jQuery('div#basket').html(data.content);
                    //    document.location.reload(true);
                    }

                });
            }
            return false;
        }	
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



         
        function minus(obj,id)
        {	
			v = $(obj).parent().children('input').val();
			v = parseInt(v);
			//v = v-1;
		//	alert(v);
			
			//	v = 1;
			if (v>1)
			{
			$(obj).parent().children('input').val(v-1);
			if (!changeQty(id))		
				$(obj).parent().children('input').val(v);
			}
			
			
		}
		
		function plus(obj,id)
        {	
			v = $(obj).parent().children('input').val();
			v = parseInt(v);
			//v = v+1;
			//alert(v);
			$(obj).parent().children('input').val(v+1);
			if (!changeQty(id))
				$(obj).parent().children('input').val(v);
			
		}       
function changeQty(id){
	//alert('s');
		var qty = $('.q-'+id).val();

            jQuery.ajax({
				
                type: 'POST',
                url: '/updamount/',
                dataType: 'json',
                async: false,
                 async: false,  
                  async: false,  
                data: {id:id, quantity:qty},                
				success: function(data){	
				
					if (data.error != undefined)
						{
						$.createNotification({content:data.error})
						result =  false;
						}
					else
					{
							 qtyItem = $('.q-'+id);
							 price =$(qtyItem).parent().parent().children('td:nth-child(3)').children('p').html();
							price = parseFloat(price)*qty;
							$(qtyItem).parent().parent().children('td:nth-child(5)').children('p').html(price+' ббаБ.');
							
							$.createNotification({content:'ааОаЛаИбаЕббаВаО баОаВаАбаОаВ аОаБаНаОаВаЛаЕаНаО'})
							 gettotal();
							 gettotalitems();
							 result =  true;
				
					}
                }
				
            });
          return result;
        }
