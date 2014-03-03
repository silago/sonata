<?php /* Smarty version 2.6.16, created on 2013-09-09 12:10:02
         compiled from ru/modules/orders/index/mail/registered.tpl */ ?>
<html>
<body>
<p>Здравствуйте!</p>
<p>&nbsp</p>
<p>
	Ваши регистрационные данные для доступа на сайт:<br/>
	Логин:		<?php echo $this->_tpl_vars['email']; ?>
<br/>
	Пароль:		<?php echo $this->_tpl_vars['pass']; ?>
<br/>
</p>
<p>&nbsp</p>
<p>Вы зарегистрированы в интернет-магазине <?php echo $this->_tpl_vars['appName']; ?>
.<br/>
	<a href="http://<?php echo $this->_tpl_vars['sitename']; ?>
"><?php echo $this->_tpl_vars['sitename']; ?>
</a>
</p>
<p>&nbsp</p>
<p>Теперь Вы можете использовать все возможности Личного кабинета!</p>
<p>&nbsp</p>
<p>Мы будем рады, если Вы заполните информацию о себе в Личном кабинете</p>
<p>&nbsp</p>
<p> --------------------- </p>
<p>&nbsp</p>
<p>
	<?php echo $this->_tpl_vars['appName']; ?>
<br/><a href="http://<?php echo $this->_tpl_vars['sitename']; ?>
"><?php echo $this->_tpl_vars['sitename']; ?>
</a><br/><?php echo $this->_tpl_vars['adminEmail']; ?>
<br/><?php echo $this->_tpl_vars['adminPhone']; ?>

</p>
</body>
</html>