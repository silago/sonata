function not_close(data){
        $(data).parent().remove();
   
}


$(document).ready(function(){
    $('ul.menu').superfish({
        delay:600, animation:{
        opacity:'show', height:'show'}
        , speed:'normal', autoArrows:false, dropShadows:false
    });
});
        $(document).ready(function(){
$("a[data-gal^='prettyPhoto']").prettyPhoto({
animationSpeed:'slow', theme:'facebook', slideshow:5000, autoplay_slideshow:true}
);
        }
);
        jQuery(document).ready(function(){
var IE = '\v' == 'v';
        jQuery("#back-top").hide();
        jQuery(function(){
jQuery(window).scroll(function(){
if (!IE){
if (jQuery(this).scrollTop() > 100){
jQuery('#back-top').fadeIn();
        }
else{
jQuery('#back-top').fadeOut();
        }
}

else{
if (jQuery(this).scrollTop() > 100){
jQuery('#back-top').show();
        }
else{
jQuery('#back-top').hide();
        }
}
}
);
        jQuery('#back-top a').click(function(){
jQuery('body,html').animate({
scrollTop:0}
, 800);
        return false;
        }
);
        }
);
        }
);
        $(function(){
$('#header .links li').last().addClass('last');
        $('.breadcrumb a').last().addClass('last');
        $('.cart tr').eq(0).addClass('first');
        }
);
        $(document).ready(function(){
$('#prod').bxSlider({
pager:true, controls:false}
);
        }
);
        $(document).ready(function(){
//$(".list-services a.tooltips").easyTooltip();
//        $(".wishlist%20a.tip").easyTooltip();
//        $(".compare%20a.tip2").easyTooltip();
        }
);
        $(document).ready(function(){
$('.column li a').css({
paddingLeft:'0px'}
);
        $('.column li a ').hover(function(){
$(this).stop().animate({
paddingLeft:'5px'}
, 300, 'easeOutQuad')}
, function(){
$(this).stop().animate({
paddingLeft:'0px'}
, 300, 'easeOutQuad')}
)
        $('.box-product.box-subcat li img').hover(function(){
jQuery(this).stop(true, false).animate({
borderTopColor:'#0078D5', borderLeftColor:'#0078D5', borderRightColor:'#0078D5', borderBottomColor:'#0078D5'}
, {
duration:250}
);
        }
, function(){
jQuery(this).stop(true, false).animate({
borderTopColor:'#dfe1e4', borderLeftColor:'#dfe1e4', borderRightColor:'#dfe1e4', borderBottomColor:'#dfe1e4'}
, {
duration:250}
);
        }
)
        $('.jcarousel-list li a img').css({
opacity:'0.3'}
);
        $('.jcarousel-list li a img').hover(function(){
jQuery(this).stop(true, false).animate({
opacity:'1'}
, {
duration:250}
);
        }
, function(){
jQuery(this).stop(true, false).animate({
opacity:'0.3'}
, {
duration:250}
);
        }
)}
);




/*
$(document).ready(function(){
	var fl = true;
    $('.addToCart').click(function(){
		if (fl){
			fl = false;
			var tis = $(this);
            var id = tis.attr("data-id");  
			$.ajax({
				url:'/addgood/', 
				type:'post', 
				data:'id=' + id+"&quantity=1", 
				dataType:'json', 
				content:this, 
				success:
					$.proxy(function(json){
						$('.success, .warning, .attention, .information, .error').remove();
						if (json['redirect']){
							location = json['redirect'];
						}

						if (json['error']){
							if (json['error']['warning']){
								$('#notification').html('<div class="warning" style="display: none;">'+ json['error']['warning']+'<span class="close"><img src="/images/close.png" alt="" class="close" /></span></div>');
							}
						}

						if (json['success']){
							alert(json['success']); 
							$('#cart-total').html(json['total']);
							$('#cart .content').html(json['output']);
							animateProduct(tis.parents().find(".image"+id+" img"), $("#cart"));
						}
					}, this)
			});
		}
	});
	function animateProduct(image, cart){
        var image_offset = image.offset();
        $("body").append('<img src="' + image.attr('src') + '" id="temp" style="position: absolute;z - index:9999;top:'+image_offset.top+'px;left:'+image_offset.left+'px" />');
        var cart_offset = cart.offset();
        params = {
            top:cart_offset.top + 'px', 
            left:cart_offset.left + 'px', 
            opacity:0.0, 
            width:cart.width(), 
            height:cart.height()
        };
        $('#temp').animate(params, 'slow', false, function(){
            $('#temp').remove();
            fl = true;
        });
    }
});
* 
* 
$(document).ready(function(){
    var fl = true;
    $('.addToCart-1').click(function(){
    if (fl){
        fl = false;
            var tis = $(this);
            $.ajax({
                url:'index.php?route=checkout/cart/add', 
                type:'post', 
                data:'product_id=' + tis.attr("data-id"), 
                dataType:'json', 
                content:this, 
                success:
                    $.proxy(function(json){
                        $('.success, .warning, .attention, .information, .error').remove();
                        if (json['redirect']){
                            location = json['redirect'];
                        }

                        if (json['error']){
                            if (json['error']['warning']){
                                $('#notification').html('<div class="warning" style="display: none;">'+ json['error']['warning']+'<span class="close"><img src="/images/close.png" alt="" class="close" /></span></div>');
                            }
                        }

                        if (json['success']){
                           
                        alert(json['success']);  
                            $('#cart-total').html(json['total']);
                            $('#cart .content').html(json['output']);
                            animateProduct(tis.parents().find(".image3 img"), $("#cart"));
                        }
                    } , this)
            });
        }
    });
    function animateProduct(image, cart){
                var image_offset = image.offset();
                        $("body").append('<img src="' + image.attr('src') + '" id="temp" style="position: absolute;z - index:9999;                        top:'+image_offset.top+'px;left:'+image_offset.left+'px" />');
                        var cart_offset = cart.offset();
                        params = {
                top:cart_offset.top + 'px', left:cart_offset.left + 'px', opacity:0.0, width:cart.width(), height:cart.height()}
                ;
                        $('#temp').animate(params, 'slow', false, function(){
                $('#temp').remove();
                        fl = true;
                }
                );
                }
                }
                );
                        $(document).ready(function(){
                $('.related-carousel .box-product ul').jcarousel({
                vertical:false, visible:4, scroll:1}
                );
                }
                );
                        $(document).ready(function(){
                $('div.image-caroucel').jcarousel({
                vertical:false, visible:3, scroll:1}
                );
                }
                );
                        var fl2 = true;
    function addToCart(product_id){
        if (fl2){
            fl2 = false;
            $.ajax({
                url:'/addgood/', 
                type:'post', 
                data:'id=' + product_id+"&quantity=1", 
                dataType:'json', 
                success:function(json){
                    $('.success, .warning, .attention, .information, .error').remove();
                    if (json['redirect']){
                        location = json['redirect'];
                    }

                    if (json['error']){
                        if (json['error']['warning']){
                            $('#notification').html('<div class="warning" style="display: none;">'+ json['error']['warning']+'<span onclick="not_close(this)" class="close"><img src="/images/close.png" alt="" class="close" /></span></div>');
                        }
                    }

                    if (json['success']){ 
                        alert(json['success']); 
                        $('#cart-total').html(json['total']);
                        $('#cart .content').html(json['output']);
                        var image = $('#img_' + product_id).offset();
                        if (image){
                            var cart = $('#cart').offset();
                            $('<img src="' + $('#img_' + product_id).attr('src') + '" id="temp" style="position: absolute;z - index:9999;top: '+ image.top+'px;left: '+ image.left+'px;" />').appendTo('body');
                            params = {
                                top:cart.top + 'px', 
                                left:cart.left + 'px', 
                                opacity:0.2, 
                                width:$('#img_' + product_id).width(), 
                                height:$('#img_' + product_id).height()
                            };
                            $('#temp').animate(params, 'slow', false, function(){
                                $('#temp').remove();
                                fl2 = true;
                            });
                        }
                        else {
                        }
                    }
                }
            });
        }
    }
*/
$(function(){
	
	$('.brands_slide').parent().append('<div class="arrs">&darr; &darr; &darr;</div>');
	
	$('.arrs').click(function(){
		$('.brands_slide').toggle(
		function(){ 
			// $('.arrs').html('&darr; &darr; &darr;');
			$('.brands_slide').slideToggle(600);
		},
		function(){
			var arr = $('.arrs');
			if(arr.html() == '↓ ↓ ↓')
				arr.html('↑ ↑ ↑');
			else
				arr.html('↓ ↓ ↓');
			
		})
	});
	

});























