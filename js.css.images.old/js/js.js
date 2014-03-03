
function addToChart(id,q){
            var quantity = q;
            $.ajax({
                type: 'POST',
                url: '/addgood/',
                data: "id="+id+"&quantity="+quantity,//{id:id,quantity:quantity},
                success: function(data){
                obj = $.parseJSON( data );
                if (obj.error != undefined)
                {
                $.createNotification({content:obj.error})
                        $('#requestfbform').remove();
                        var html = "";
                        html+="<div id='requestfbform'>";
                        html+="<form action='' method='post'>";
                        html+=" <h4> Данный товар временно отсутствует. Заполните форму ниже и мы проинформируем вас, когда этот товар появится на складе</h4>";
                        html+="<h5>  </h5>";
                        html+=" <input type='text' name='cname' placeholder='Имя' />";
                        html+=" <input type='text' name='email' placeholder='Email' />";
                        html+=" <input type='text' name='message' placeholder='Текст сообщения' />";
                        html+=" <input type='submit' value='Отправить заявку' />";
                        html+="</form>";
                        $('body').append(html);
                        $("#requestfbform form").submit(function(e)
                        {
                        e.preventDefault();
                        var name = $('input[name=cname]').val();
                        var email = $('input[name=email]').val();
                        var message = $('input[name=message]').val();
                        $.ajax({
                                    type: "POST",
                                    url: "/fb",
                                    data: {cname: name, fname:"", email: email, theme:"Бронирование товара", message:message  },
                                    success: function(msg){
                                    $('#requestfbform form h5').html(msg);
                                    if (msg=="Письмо успешно отправлено")
                                        {
                                        $("#requestfbform").delay(1000).hide(300);
                                        $("#requestfbform input").hide();
                                        }
                                    //console.log(msg);
                                    }
                                });
                        });
                
                }	
                else
					{
                        $.createNotification({content:'Товар успешно добавлен'})
          
                    
                    }
                 gettotal();
                 gettotalitems();
			
                }
            });

            //div.html('<a href="#" class="'+id+'" onclick="return addToChart(&quot;'+id+'&quot;)">УТДУТОУТБУТАУТВУТЛУТЕУТН</a>');          
            
        return false;
        }

function gettotal(){
            //var div = $("a."+id).parent();            
           
            $.ajax({
                type: 'POST',
                url: '/totalbill/',
            
                success: function(data){
				$('.totalprice').html(data);
				$('.tableBottom span').first().html(data+' руб.');
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
                    //    jQuery('div#error').html('ааАаПаИбб б баКаАаЗаАаНаНбаМ email аАаДбаЕбаОаМ баЖаЕ бббаЕббаВбаЕб аВ аБаАаЗаЕ аДаАаНаНбб. ааОаПбаОаБбаЙбаЕ аАаВбаОбаИаЗаОаВаАбббб');
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


function deleteFromCart(id) {
            if (confirm('Удалить товар?')) {
                jQuery.ajax({
                    type: 'POST',
                    url: '/delformcart/',
                    dataType: 'json',
                    data: {id: id},
                    success: function(data) {
                        if (data.amount > 0) {
                            jQuery('.upBasket').find('b').html(data.amount);
                        } else {
                            jQuery('.upBasket').html('<p class="upBasket"><a href="/basket/">корзина:</a> ваша корзина <b>пуста</b></p>')
                        }
						$('.q-'+id).closest('tr').hide(300);
						//console.log(id);
						$.createNotification({content:'Товар успешно удален'})
						
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
							$(qtyItem).parent().parent().children('td:nth-child(5)').children('p').html(price+' руб.');
							
							$.createNotification({content:'Количество товаров обновлено'})
							 gettotal();
							 gettotalitems();
							 result =  true;
				
					}
                }
				
            });
          return result;
        }
$(document).ready (function () {	
	 gettotal();
     gettotalitems();
	
});

	$(document).ready( function()
		{
			$('.image-additional ul li a').click(function(e) {
				e.preventDefault();
			//	alert('s');
				$('.imain').hide().attr("src",$(this).attr('href')).fadeIn(500);
				return false;
			});
	//tmp_li
			
	 

	$('.content-box .box-product img').last().load( function() {	 sortli('.content-box .box-product');	});
	$('#content .product-grid img').last().load( 	 function() {	 sortli('#content .product-grid');		});
	
		});



//grid_a
function sortli(cl){
	//	alert('s');
		var i_li=0; 
	$(cl+' ul li').each(function(){
		
		if ( i_li%3==1)
			{		
			var prev_h = $(this).prev().height();
			var next_h = $(this).next().height();
			var cur_h =  $(this).height();
				
					
				if (prev_h > cur_h)		$(this).css('height', prev_h+'px');
					else $(this).prev().css('height', cur_h+'px');
			
			var prev_h = $(this).prev().height();
			var next_h = $(this).next().height();
			var cur_h =  $(this).height();
						
			
				
				if (next_h > cur_h)		$(this).css('height', next_h+'px');
					else $(this).next().css('height', cur_h+'px');
			
			var prev_h = $(this).prev().height();
			var next_h = $(this).next().height();
			var cur_h =  $(this).height();
						
				if (prev_h > cur_h)		$(this).css('height', prev_h+'px');
					else $(this).prev().css('height', cur_h+'px');
				
			}
			
			
	
		
		i_li++;
		
		
		
		});};
