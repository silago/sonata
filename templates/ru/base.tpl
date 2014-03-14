
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$pageTitle}</title>
<link rel="stylesheet" type="text/css" href="/css/main.css" />
<link rel="stylesheet" type="text/css" href="/css/fonts.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<link href="/css/notification.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="/js/jquery.selectBox.js"></script>
<script type="text/javascript" src="/js/niceRadio.js"></script>

<script type="text/javascript" src="/js/js.js"></script>
<script type="text/javascript" src="/js/jquery.notification.js"></script>


<script type="text/javascript" src="/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="/js/niceCheckbox.js"></script>
<link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />


{literal}
<script type="text/javascript">
  $(function() {
	  $.datepicker.regional['ru'] = { 
closeText: 'Закрыть', 
prevText: '&#x3c;Пред', 
nextText: 'След&#x3e;', 
currentText: 'Сегодня', 
monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 
'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], 
monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 
'Июл','Авг','Сен','Окт','Ноя','Дек'], 
dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'], 
dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'], 
dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'], 
dateFormat: 'dd.mm.yy', 
firstDay: 1, 
isRTL: false 
}; 

$.datepicker.setDefaults($.datepicker.regional['ru']); 
	  
	  
	  
	  
	  
    $('.fancybox').fancybox();

    $( "#datepicker" ).datepicker({
      minDate: (new Date(new Date().getTime()+24 * 60 * 60 * 1000)),
      //minDate: "dateTomorrow",
      
      showOn: "button",
      buttonImage: "/images/calendare.png",
      buttonImageOnly: true
    });
  });
  </script>
  <script type="text/javascript">
 $(document).ready(function() {
     $("select").selectBox();
 });
 </script>
{/literal}
</head>
<body>
	<div class="top-head"margin-left:-15px; margin-bottom:-20px; >
		<div class="wrap">
			<div class="enter-box">
			{top_form}
            <!--
                <span>Линый кабинет</span>	
				<a href="/login/">Войти</a>
			-->
            </div>	

			<div class="basket-box">
				<span>В вашей корзине</span>
				<a class="countOfItems" href="/basket/"><i>0</i> товаров</a>
				<a class="bs-button" href="/basket/">Заказать</a>
			</div>
		</div>	
	</div>

	<div class="header">
		<div class="wrap">
			<div class="logo">
				<a href="/"><img src="/images/logo.png" height="69" width="256" alt="" /></a>	
			</div>	

			<div class="search">
				<form action="/catalogsearch"  method="post">
					<input type="text" name="catalogSearch" placeholder="Поиск">	
					<input type="submit">
				</form>	 
			</div>

			<div class="phone">
				<img src="/images/girl.png" height="59" width="59" alt="" />	
				<div class="phone-number">
					<p><strong>8 (3952)</strong> 505-818</p>	
					<span>Многоканальный</span>
				</div>
			</div>
		</div>	
	</div>

	<div class="wrap">
		<div class="menu">

            {show_menu menuid=2}
		</div>	
	</div>
    <div class="clear"> </div>
	<div class="bg">
		<div class="wrap">
              {block name=content}               
			        <div class="service-box">
                        {$content}
			        </div>	
              {/block}
		</div>
	</div>
    {block name=bottom}
    
    {/block}

	<!-- footer -->
	<div class="footer_blank"></div>

<div id="footer">
	<div class="sub-info">
		<div class="sub-box">
		
        {show_banner section=bottom1}
        <!--
        <span>Способы оплаты:</span>	
			<p><a href="#">Наличный расчет</a></p>
			<p><a href="#">Безналичный расчет</a></p>
		-->
            </div>
        
		
        <div class="sub-box">
        {show_banner section=bottom2}
		<!--
        <span>Мы принимаем:</span>	
			<a href="#"><img src="/images/visa.png" height="34" width="58" alt="" /></a>
			<a href="#"><img src="/images/mastercard.png" height="34" width="58" alt="" /></a>
		-->
            </div>	
        

		        <div class="sub-box">
        {show_banner section=bottom3}
		<!--
            <span>Адрес и почта:</span>	
			<p class="address">г. Иркутск, ул. Декабрьских событий 50/1</p>
			<p class="mail"><a href="mailto:soneta@sonetarf.ru">soneta@sonetarf.ru</a></p>
		-->
            </div>
        
		<div class="clear"></div>

		<p class="copyright">© Copyright ООО «Сонета» 1992-2014 Все права защищены.</p>
	</div>

	<div class="sub-phone">
		
                        {show_banner section=bottom4}
        <!--
*/*/        <span>Многоканльный:</span>	
		<p><strong>8 (3952)</strong> 505-818</p>

		<span>Факс / бухгалтерия:</span>	
		<p><strong>8 (3952)</strong> 30-19-02</p>
	    -->
        </div>
</div>

</body>
</html>
