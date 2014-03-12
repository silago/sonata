


$('document').ready( function()
{
    gettotalitems();


    $('ul.main-menu li').not('.active').children('ul').hide();
    url = window.location.href.toString().split('?')[0].split(window.location.host)[1];
    url2 = '/'+window.location.href.toString().split('?')[0].split(window.location.host)[1].split('/')[1];
    //url2='123123123312';
    $('ul.main-menu').find('a').each( function()
    {
        if (($(this).attr('href')==url) || ($(this).attr('href')==url2 ))
        {  
            $(this).parent().children('ul').show();
            $(this).closest('div > ul.main-menu > li').addClass('active').children('a').addClass('active-a');
            $(this).parents('ul').show();
        }
       
    });
/*
    $('ul.main-menu li').each(function()
        {   
            if ($(this).children('ul').length!=0)
            $(this).children('a').click(function(e){
                e.preventDefault();
                $(this).parent().children('ul').toggle();});
            });

        });
*/



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
					    document.location.reload(true);	
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
				$('.countOfItems i').html(data+'&nbsp;');
                }
            });
        return false;
        }        



function registergo(id){//alert(1);   
	$('div.err').hide();
        var ser = jQuery('form#'+id).serialize();
        $('div#error').hide();
        $('#register input[type=submit]').attr('disabled','disabled');
        $('.alert-input').removeClass('alert-input');
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
					
                    html1 = '<p class="alert-text">';
                    html2 = '<img width="3" height="10" alt="" src="/images/ln.png"></p>';
                    for (var key in data) {
									var val = data [key];

                                    html = html1+val+html2;
                                    $('input[name='+key+']').addClass('alert-input').after(html);
									//$('input[name='+key+']').val(val);
									//$('div.err'+key).html(val);
									//$('div.err'+key).show();
									//alert (key+' = '+val);
								}


                    for(i=-1;i<data.count;i++){                                             
                        var html = jQuery('div#error').html();
                        console.log(data[i]);
                        
                        
								


                        if(!(data[i] == undefined)){
                            jQuery('div#error').html(html + data[i]+'<br/>');
                        }
                    }

				$('#error').show();
                $('#register input[type=submit]').removeAttr('disabled');  
                }
                else
                {   
                    if (typeof(data.goto)!='undefined')
					    document.location=data.goto;
                    else document.location = '/';
                }
                    // alert(data);
                console.log(data.length)
                console.log(data);                  
            }
        })
        return false;
}



         
        function minus(obj,id)
        {	
			v = $('.q-'+id).val();
            v = parseInt(v);
			if (v>1)
			{
			$(obj).parent().children('input').val(v-1);
			if (!changeQty(id))		
				$(obj).parent().children('input').val(v);
			}
            recount(obj,v-1);
		}
		
        function recount(obj,q)
            {
            if (q > 0) { 
			var ed = parseFloat($(obj).closest('tr').find('.ed').html());
            var val = ed*q;
            $(obj).closest('tr').find('.summ').find('span').html(val.toFixed(2)+' руб.');
            }}

		function plus(obj,id)
        {   
            console.log(id);
			v = $('.q-'+id).val();
			v = parseInt(v);
			//v = v+1;
			//alert(v);
			$(obj).parent().children('input').val(v+1);
			if (!changeQty(id))
				$(obj).parent().children('input').val(v);
            recount(obj,v+1);

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
							
							$.createNotification({content:'Количество товаров обновлено'})
							 gettotal();
							 gettotalitems();
							 result =  true;
				
					}
                }
				
            });
          return result;
        }
