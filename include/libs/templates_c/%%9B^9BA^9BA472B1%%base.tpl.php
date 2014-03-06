<?php /* Smarty version 2.6.16, created on 2014-03-06 13:28:55
         compiled from ru/base.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'top_form', 'ru/base.tpl', 27, false),array('function', 'pages_menu_ul', 'ru/base.tpl', 67, false),array('block', 'block', 'ru/base.tpl', 73, false),)), $this); ?>

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


</head>
<body>
	<div class="top-head"margin-left:-15px; margin-bottom:-20px; >
		<div class="wrap">
			<div class="enter-box">
			<?php echo smarty_function_top_form(array(), $this);?>

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
            <?php echo smarty_function_pages_menu_ul(array(), $this);?>

		</div>	
	</div>
    <div class="clear"> </div>
	<div class="bg">
		<div class="wrap">
              <?php $this->_tag_stack[] = array('block', array('name' => 'content')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>               
			        <div class="service-box">
                        <?php echo $this->_tpl_vars['content']; ?>

			        </div>	
              <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		</div>
	</div>
    <?php $this->_tag_stack[] = array('block', array('name' => 'bottom')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

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