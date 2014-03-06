
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>title</title>
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

{literal}
<script>
  $(function() {
    $( "#datepicker" ).datepicker({
      showOn: "button",
      buttonImage: "images/calendare.png",
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
            {pages_menu_ul}
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
			<span>Способы оплаты:</span>	
			<p><a href="#">Наличный расчет</a></p>
			<p><a href="#">Безналичный расчет</a></p>
		</div>

		<div class="sub-box">
			<span>Мы принимаем:</span>	
			<a href="#"><img src="/images/visa.png" height="34" width="58" alt="" /></a>
			<a href="#"><img src="/images/mastercard.png" height="34" width="58" alt="" /></a>
		</div>	

		<div class="sub-box">
			<span>Адрес и почта:</span>	
			<p class="address">г. Иркутск, ул. Декабрьских событий 50/1</p>
			<p class="mail"><a href="mailto:soneta@sonetarf.ru">soneta@sonetarf.ru</a></p>
		</div>
		<div class="clear"></div>

		<p class="copyright">© Copyright ООО «Сонета» 1992-2014 Все права защищены.</p>
	</div>

	<div class="sub-phone">
		<span>Многоканльный:</span>	
		<p><strong>8 (3952)</strong> 505-818</p>

		<span>Факс / бухгалтерия:</span>	
		<p><strong>8 (3952)</strong> 30-19-02</p>
	</div>
</div>

</body>
</html>
