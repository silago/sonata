$(document).ready (function () {	
	// для меню каталога
	$("div.subnav li:not(.active)").children('ul').css ('display','none');			
});

function addToChart(id){
            // var div = $("a."+id).parent();            
            var quantity = 1;
            // $("a."+id).parent().html('<img src="/img/ajax-loader.gif" style="width:16px;height:16px;">');
            // quantity = $('.q-'+id).val();
            $.ajax({
                type: 'POST',
                url: '/addgood/',
                data: "id="+id+"&quantity="+quantity,//{id:id,quantity:quantity},
                success: function(data){
                //$('p.upBasket').html('<a href="/basket/">ÐºÐ¾Ñ€Ð·Ð¸Ð½Ð°:</a> Ñ‚Ð¾Ð²Ð°Ñ€Ð¾Ð² Ð² ÐºÐ¾Ñ€Ð·Ð¸Ð½Ðµ  - <b>'+data+'</b>')
                //     delformcart('0');
				// c = parseInt($('.itemcount').html())+parseInt(quantity);
                // $('.itemcount').html(c);
                // $('.itemcount2').html(c);
                
               
                
                 gettotal();
                 gettotalitems();
				
				$('.popupBadWindow').show();
					
				$('.inBasket').fadeOut (250, function () {
					$('.inBasket').text ('Товар добавлен');
					$('.inBasket').fadeIn (250) .delay (2000). fadeOut (250, function () {
						$('.inBasket').text ('В корзину');
						$('.inBasket').fadeIn (250);
					});
				})
                // $('.popupBadWindow').show();
                }
            });

            //div.html('<a href="#" class="'+id+'" onclick="return addToChart(&quot;'+id+'&quot;)">Ð´Ð¾Ð±Ð°Ð²Ð»ÐµÐ½</a>');          
            
        return false;
        }

function gettotal(){
            //var div = $("a."+id).parent();            
           
            $.ajax({
                type: 'POST',
                url: '/totalbill/',
            
                success: function(data){
				$('.totalprice').html(data);
                }
            });

          

        return false;
        }
        
function gettotalitems(){
            //var div = $("a."+id).parent();            
           
            $.ajax({
                type: 'POST',
                url: '/totalitems/',
            
                success: function(data){
				$('.countOfItems').html(data);
                }
            });

          

        return false;
        }        


function registerandcheckout(elem){
		//$('.formphoneinput').val(  $('.i-text.width-60 input').val()+$('.i-text.width-150 input').val());
		var form = jQuery(elem).serialize();		
		//$('div#error').hide();
		
		jQuery.ajax({
                type: 'POST',                
				url: '/registerandcheckout/',
				dataType: "json",
                data: {form:form},
                success: function(data){

                    if(data.registered == true){
                    //    jQuery('#error').addClass('alert').addClass('alert-info');
                    //    jQuery('div#error').html('Запись с указанным email адресом уже существует в базе данных. Попробуйте авторизоваться');
                    //    jQuery('div#forms').html(data.form);
                    //     $('div#error').show();

                    }else{
                        if(data.length > 0){
                      //      jQuery('#error').html('');
					//		jQuery('#error').addClass('alert').addClass('alert-error');
                     //       for(i = 0; i<data.length; i++){
                      //          var html = jQuery('#error').html();
                       //         jQuery('#error').html(html + data[i] + '<br>');
                        //        jQuery('#error').addClass('alert').addClass('alert-error');
                         //        $('div#error').show();
                          //{literal  }
                        }else{
                            jQuery(elem).find('button[type="submit"]').attr('disabled', 'disabled');
							document.location.href='/checkout/';
                        }
                    }
				}
            });
		
		return false;
	}


     
        
        function minus(obj,id)
        {
			v = $(obj).parent().children('input').val();
			v = parseInt(v);
			v = v-1;
			
			if (v<0)
				v = 0;
		
				
			$(obj).parent().children('input').val(v);
			
			changeQty(id);
			
		}
		
		function plus(obj,id)
        {
			v = $(obj).parent().children('input').val();
			v = parseInt(v);
			$(obj).parent().children('input').val(v+1);
			changeQty(id);
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

function changeQty(id){
		var qty = $('.q-'+id).val();

            jQuery.ajax({
                type: 'POST',
                url: '/updamount/',
                dataType: 'json',
                data: {id:id, quantity:qty},                
				success: function(data){					         
					if(data.amount > 0){
							jQuery('.upBasket').find('b').html(data.amount);
					}else{
							jQuery('.upBasket').html('<p class="upBasket"><a href="/basket/">корзина:</a>ваша корзина <b>пуста</b></p>')
					}					
					jQuery('div#basket').empty();
                    jQuery('div#basket').html(data.content);                    
                    jQuery('.upBasket').find('b').html(data.amount);
                    document.location.reload(true);
                }
				
            });
          return false;
        }
